<?php
namespace Modules\Booking\Controllers;

use Log;
use Validator;
use DebugBar\DebugBar;
use Mockery\Exception;
use App\BookingPayment;
use Illuminate\Http\Request;
use App\Helpers\ReCaptchaEngine;
use Illuminate\Support\Facades\DB;
use Modules\Booking\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Http;

class BookingController extends \App\Http\Controllers\Controller
{
    use AuthorizesRequests;
    protected $booking;

    public function __construct()
    {
        $this->booking = Booking::class;
    }

    public function checkout()
    {
        // $test =  new EasyPaisaGateway();
        // $authToken = $test->getAuthToken();
        // echo $authToken; die;
        // $test->verifyToken($authToken); die;
        if(!Cart::count()){
            return redirect()->route('booking.cart');
        }

        $data = [
            'avatar_url'=>'asdf',
            'page_title' => __('Checkout'),
            'gateways'   => $this->getGateways(),
            'user'       => Auth::user(),
            'breadcrumbs'=>[
                ['name'=>__("Checkout"),'class'=>'active']
            ]
        ];
        return view('Booking::frontend.checkout', $data);
    }

    public function cart()
    {
        $data = [
            'page_title' => __('Cart'),
            'user'       => Auth::user(),
            'breadcrumbs'=>[
                ['name'=>__("Cart"),'class'=>'active']
            ]
        ];
        return view('Booking::frontend.cart', $data);
    }

    public function checkStatusCheckout($code)
    {
        $booking = $this->booking::where('code', $code)->first();
        $data = [
            'error'    => false,
            'message'  => '',
            'redirect' => ''
        ];
        if (empty($booking)) {
            $data = [
                'error'    => true,
                'redirect' => url('/')
            ];
        }
        if ($booking->customer_id != Auth::id()) {
            $data = [
                'error'    => true,
                'redirect' => url('/')
            ];
        }
        if ($booking->status != 'draft') {
            $data = [
                'error'    => true,
                'redirect' => url('/')
            ];
        }
        return response()->json($data, 200);
    }

 public function doCheckout(Request $request)
{
    if (!Cart::count()) {
        return $this->sendError(__("Your cart is empty"));
    }

    // Google ReCaptcha validation
    if (ReCaptchaEngine::isEnable() && setting_item("booking_enable_recaptcha")) {
        $codeCapcha = $request->input('g-recaptcha-response');
        if (!$codeCapcha || !ReCaptchaEngine::verify($codeCapcha)) {
            return $this->sendError(__("Please verify the captcha"));
        }
    }

    $rules = [
        'first_name'      => 'required|string|max:255',
        'last_name'       => 'required|string|max:255',
        'email'           => 'required|string|email|max:255',
        'phone'           => 'required|string|max:255',
        'country'         => 'required',
        'payment_gateway' => 'required',
        'term_conditions' => 'required'
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return $this->sendError('', ['errors' => $validator->errors()]);
    }

    $payment_gateway = $request->input('payment_gateway');
    
    // Handle case where multiple payment_gateway values are sent (array)
    if (is_array($payment_gateway)) {
        $payment_gateway = end($payment_gateway); // Get the last value
    }
    $gateways = get_payment_gateways();

    $gatewayObj = null;
    if ($payment_gateway !== 'easypaisa') {
        if (empty($gateways[$payment_gateway]) || !class_exists($gateways[$payment_gateway])) {
            return $this->sendError(__("Payment gateway not found"));
        }

        $gatewayObj = new $gateways[$payment_gateway]($payment_gateway);

        if (!$gatewayObj->isAvailable()) {
            return $this->sendError(__("Payment gateway is not available"));
        }
    }

    try {
        $booking = new Booking();
        $booking->status = 'draft';
        $booking->first_name = $request->input('first_name');
        $booking->last_name = $request->input('last_name');
        $booking->email = $request->input('email');
        $booking->phone = $request->input('phone');
        $booking->address = $request->input('address_line_1');
        $booking->address2 = $request->input('address_line_2');
        $booking->city = $request->input('city');
        $booking->state = $request->input('state');
        $booking->zip_code = $request->input('zip_code');
        $booking->country = $request->input('country');
        $booking->gateway = $payment_gateway;
        $booking->total = Cart::total();
        $booking->customer_id = Auth::id();
        $booking->save();
        $booking->saveItems();

        $booking = Booking::find($booking->id);

        $user = Auth::user();
        $user->billing_first_name = $request->input('first_name');
        $user->billing_last_name = $request->input('last_name');
        $user->billing_phone = $request->input('phone');
        $user->billing_address = $request->input('address_line_1');
        $user->billing_address2 = $request->input('address_line_2');
        $user->billing_city = $request->input('city');
        $user->billing_state = $request->input('state');
        $user->billing_zip_code = $request->input('zip_code');
        $user->billing_country = $request->input('country');
        $user->save();

        $booking->addMeta('locale', app()->getLocale());

        // Debug: Log the payment gateway being processed
        \Log::info('Processing payment with gateway: ' . $payment_gateway);
        \Log::info('All payment_gateway values: ' . json_encode($request->input('payment_gateway')));
        \Log::info('Request data: ' . json_encode($request->all()));

        // Stripe Payment Processing
        if ($payment_gateway == 'stripe') {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $paymentMethodId = $request->input('payment_method_id');
            if (!$paymentMethodId) {
                return $this->sendError('Payment method ID is required');
            }

            try {
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => intval($booking->total * 100), // amount in cents
                    'currency' => 'usd', // change if needed
                    'payment_method' => $paymentMethodId,
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                    'metadata' => [
                        'booking_id' => $booking->id,
                        'customer_email' => $booking->email,
                    ],
                    'return_url' => route('booking.confirmPayment', ['gateway' => 'stripe']),
                ]);

                if ($paymentIntent->status == 'requires_action' && $paymentIntent->next_action->type == 'use_stripe_sdk') {
                    return response()->json([
                        'requires_action' => true,
                        'payment_intent_client_secret' => $paymentIntent->client_secret,
                    ]);
                } elseif ($paymentIntent->status == 'succeeded') {
                    $booking->status = 'confirmed';
                    $booking->save();
                    BookingPayment::create([
                        'booking_id' => $booking->id,
                        'payment_gateway' => 'stripe',
                        'amount' => $booking->total,
                        'currency' => 'usd',  // or dynamic if you want
                        'converted_amount' => $booking->total,
                        'converted_currency' => 'usd',
                        'exchange_rate' => 1,
                        'status' => $paymentIntent->status,
                        'logs' => json_encode($paymentIntent),
                        'create_user' => Auth::id(),
                        'update_user' => Auth::id(),
                    ]);

                    Cart::destroy();
            
                    // Mail::to($booking->email)->send(new \App\Mail\BookingConfirmed($booking));
                   
                    return response()->json([
                        'success' => true,
                        'redirect_url' => route('booking.detail', ['code' => $booking->code])
                    ]);
                } else {
                    return $this->sendError('Invalid PaymentIntent status');
                }
            } catch (\Exception $e) {
                return $this->sendError($e->getMessage());
            }
        }

        // Easypaisa Payment Processing
        if ($payment_gateway == 'easypaisa') {
            try {
                $storeId       = config('easypaisa.store_id');
                $accountId     = config('easypaisa.account_id');
                $merchantName  = config('easypaisa.merchant_name');
                $secretKey     = config('easypaisa.secret_key');
                $currency      = config('easypaisa.currency', 'PKR');
                $payMethod     = config('easypaisa.payment_method', 'MA');
                $returnUrl     = config('easypaisa.return_url');
                $cancelUrl     = config('easypaisa.cancel_url');
                $callbackUrl   = config('easypaisa.callback_url');
                $baseUrl       = rtrim(config('easypaisa.base_url'), '/');

                if (!$storeId || !$secretKey || !$callbackUrl || !$baseUrl) {
                    return $this->sendError('Easypaisa configuration missing.');
                }

                $orderRef = 'EP_' . $booking->id . '_' . time();
                $booking->addMeta('easypaisa_order_ref', $orderRef);
                $booking->save();

                $amount      = number_format((float)$booking->total, 2, '.', '');
                $expiryDate  = date('Ymd', strtotime('+24 hours'));

                $payload = [
                    'storeId'        => $storeId,
                    'accountId'      => $accountId,
                    'merchantName'   => $merchantName,
                    'orderRefNum'    => $orderRef,
                    'amount'         => $amount,
                    'paymentMethod'  => $payMethod,
                    'currency'       => $currency,
                    'returnUrl'      => $returnUrl,
                    'cancelUrl'      => $cancelUrl,
                    'postBackURL'    => $callbackUrl,
                    'expiryDate'     => $expiryDate,
                    'autoRedirect'   => '1',
                ];

                $signatureString = $storeId . '&' . $orderRef . '&' . $amount . '&' . $expiryDate;
                $payload['merchantHashedReq'] = hash_hmac('sha256', $signatureString, $secretKey);

                $endpoint = $baseUrl . '/transactions';
                $response = Http::asJson()->post($endpoint, $payload);

                \Log::info('Easypaisa initiate response', [
                    'endpoint' => $endpoint,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    if (!empty($json['paymentUrl'])) {
                        return redirect()->away($json['paymentUrl']);
                    }
                }

                // Fallback to hosted form if REST API does not respond as expected
                $mode = strtolower(config('easypaisa.mode', 'sandbox'));
                $formBase = $mode === 'production' ? 'https://easypay.easypaisa.com.pk' : 'https://easypaystg.easypaisa.com.pk';
                $formAction = rtrim($formBase, '/') . '/easypay/Index.jsf';

                $html = '<!DOCTYPE html><html><head><title>Redirecting...</title></head><body>';
                $html .= '<p>Redirecting to Easypaisa...</p>';
                $html .= '<form id="epForm" method="POST" action="' . htmlspecialchars($formAction, ENT_QUOTES, 'UTF-8') . '">';
                foreach ($payload as $key => $value) {
                    $html .= '<input type="hidden" name="' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') . '">';
                }
                $html .= '</form><script>(function(){function s(){try{var f=document.getElementById("epForm");if(f){f.submit();}}catch(e){}}if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",s);}else{setTimeout(s,0);}})();</script></body></html>';
                return response($html)->header('Content-Type', 'text/html');
            } catch (\Exception $e) {
                return $this->sendError($e->getMessage());
            }
        }

        // Other gateways process normally
        \Log::info('Processing non-Stripe gateway: ' . $payment_gateway);
        Cart::destroy();
        return $gatewayObj->process($request, $booking);

    } catch (\Exception $exception) {
        if (isset($booking)) {
            $booking->delete();
        }
        return $this->sendError($exception->getMessage().' - '.$exception->getFile().' - '.$exception->getLine());
    }
    }

    public function easypaisaCallback(Request $request)
    {
        \Log::info('Easypaisa callback received', [
            'data' => $request->all(),
            'headers' => $request->headers->all(),
        ]);

        $payloadAll = $request->all();
        $lower = [];
        foreach ($payloadAll as $k => $v) { $lower[strtolower($k)] = $v; }

        // Accept multiple possible keys for order reference (providers vary)
        $orderRef = $request->input('orderRefNum')
            ?: $request->input('orderRef')
            ?: ($lower['orderrefnum'] ?? null)
            ?: ($lower['orderref'] ?? null)
            ?: ($lower['orderrefnumber'] ?? null)
            ?: ($lower['orderid'] ?? null)
            ?: $request->query('orderRefNum')
            ?: $request->query('orderRef');

        // Map response/status code from various fields
        $responseCode = $request->input('responseCode')
            ?: $request->input('status')
            ?: ($lower['responsecode'] ?? null)
            ?: ($lower['status'] ?? null);

        $amount = $request->input('amount') ?? ($lower['amount'] ?? null);

        if (!$orderRef) {
            return response()->json(['status' => false, 'message' => 'Missing orderRefNum'], 422);
        }

        $booking = Booking::whereHas('meta', function($q) use ($orderRef) {
            $q->where('name','easypaisa_order_ref')->where('val',$orderRef);
        })->first();

        if (!$booking) {
            return response()->json(['status' => false, 'message' => 'Booking not found'], 404);
        }

        if ($amount !== null && number_format((float)$booking->total, 2, '.', '') !== number_format((float)$amount, 2, '.', '')) {
            return response()->json(['status' => false, 'message' => 'Amount mismatch'], 422);
        }

        if (strtoupper((string)$responseCode) === '0000' || strtoupper((string)$responseCode) === 'SUCCESS') {
            $booking->status = 'confirmed';
            $booking->save();
            BookingPayment::create([
                'booking_id' => $booking->id,
                'payment_gateway' => 'easypaisa',
                'amount' => $booking->total,
                'currency' => 'PKR',
                'converted_amount' => $booking->total,
                'converted_currency' => 'PKR',
                'exchange_rate' => 1,
                'status' => 'succeeded',
                'logs' => json_encode($request->all()),
                'create_user' => $booking->customer_id,
                'update_user' => $booking->customer_id,
            ]);
            return response()->json(['status' => true]);
        }

        $booking->status = 'cancelled';
        $booking->save();
        BookingPayment::create([
            'booking_id' => $booking->id,
            'payment_gateway' => 'easypaisa',
            'amount' => $booking->total,
            'currency' => 'PKR',
            'converted_amount' => $booking->total,
            'converted_currency' => 'PKR',
            'exchange_rate' => 1,
            'status' => 'failed',
            'logs' => json_encode($request->all()),
            'create_user' => $booking->customer_id,
            'update_user' => $booking->customer_id,
        ]);
        return response()->json(['status' => false]);
    }

/**
 * Handle EasyPaisa payment cancellation
 */
public function handleEasyPaisaCancel(Request $request)
{
    // Log the cancellation for debugging
    \Log::info('EasyPaisa Payment Cancelled', [
        'request_data' => $request->all(),
        'user_id' => auth()->id()
    ]);

    // Redirect back to checkout with a message and URL parameter
    return redirect()->route('booking.checkout', ['payment_cancelled' => '1'])
        ->with('error', 'Payment was cancelled. You can try again or choose a different payment method.');
}

/**
 * Handle payment confirmation after redirect
 */
public function confirmPayment(Request $request, $gateway)
{
    if ($gateway === 'easypaisa') {
        return $this->easypaisaCallback($request);
    }
    
    if ($gateway !== 'stripe') {
        return $this->sendError(__("Unsupported payment gateway"));
    }

    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    $paymentIntentId = $request->input('payment_intent');
    if (!$paymentIntentId) {
        return $this->sendError("Payment Intent ID missing");
    }

    try {
        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        if ($paymentIntent->status == 'succeeded') {
            $bookingId = $paymentIntent->metadata->booking_id ?? null;
            if (!$bookingId) {
                return $this->sendError("Booking ID missing in payment metadata");
            }

            $booking = Booking::find($bookingId);
            if (!$booking) {
                return $this->sendError("Booking not found");
            }

            $booking->status = 'confirmed';
            $booking->save();

            Cart::destroy();

            return redirect()->route('booking.detail', ['code' => $booking->code])->with('success', 'Payment confirmed successfully.');
        } elseif ($paymentIntent->status == 'requires_payment_method') {
            // Payment failed, ask user to try again
            return redirect()->route('booking.checkout')->withErrors('Payment failed, please try again.');
        } else {
            return redirect()->route('booking.checkout')->withErrors('Payment processing, please wait or try again.');
        }
    } catch (\Exception $e) {
        return redirect()->route('booking.checkout')->withErrors($e->getMessage());
    }
}
    public function cancelPayment(Request $request, $gateway)
    {

        $gateways = get_payment_gateways();
        if (empty($gateways[$gateway]) or !class_exists($gateways[$gateway])) {
           return $this->sendError(__("Payment gateway not found"));
        }
        $gatewayObj = new $gateways[$gateway]($gateway);
        if (!$gatewayObj->isAvailable()) {
           return $this->sendError(__("Payment gateway is not available"));
        }
        return $gatewayObj->cancelPayment($request);
    }

    /**
     * @todo Handle Add To Cart Validate
     *
     * @param Request $request
     * @return string json
     */
    public function addToCart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id'   => 'required|integer',
            'type' => 'required'
        ]);
        if ($validator->fails()) {
           return $this->sendError('', ['errors' => $validator->errors()]);
        }
        $service_type = $request->input('type');
        $service_id = $request->input('id');
        $allServices = get_bookable_services();
        if (empty($allServices[$service_type])) {
           return $this->sendError(__('Service type not found'));
        }
        $module = $allServices[$service_type];
        $service = $module::find($service_id);

        if (empty($service) or !is_subclass_of($service, '\\Modules\\Booking\\Models\\Bookable')) {
           return $this->sendError(__('Service not found'));
        }
        if (!$service->isBookable()) {
           return $this->sendError(__('Service is not bookable'));
        }
        return $service->addToCart($request);
    }

    protected function getGateways()
    {

        $all = get_payment_gateways();
        $res = [];
        foreach ($all as $k => $item) {
            if (class_exists($item)) {
                $obj = new $item($k);
                if ($obj->isAvailable()) {
                    $res[$k] = $obj;
                }
            }
        }
        return $res;
    }

    public function detail(Request $request, $code)
    {
        $booking = Booking::where('code', $code)->first();
        if (empty($booking)) {
            abort(404);
        }

        if ($booking->status == 'draft') {
            return redirect($booking->getCheckoutUrl());
        }
        if ($booking->customer_id != Auth::id()) {
            abort(404);
        }
        $data = [
            'page_title' => __('Order Details'),
            'booking'    => $booking,
            'hideBc'=>1
        ];
        if ($booking->gateway) {
            $data['gateway'] = get_payment_gateway_obj($booking->gateway);
        }
        return view('Booking::frontend/detail', $data);
    }

    public function removeCartItem(Request $request){
        $validator = Validator::make($request->all(), [
            'id'   => 'required',
        ]);
        if ($validator->fails()) {
           return $this->sendError('', ['errors' => $validator->errors()]);
        }

        Cart::remove($request->input('id'));

        return $this->sendSuccess([
            'fragments'=>get_cart_fragments(),
            'reload'=>Cart::count()  ? false: true,
        ],__("Item removed"));
    }

	public function exportIcal($service_type = 'tour', $id)
	{
		\Debugbar::disable();
		$allServices = get_bookable_services();
		if (empty($allServices[$service_type])) {
			return $this->sendError(__('Service type not found'));
		}
		$module = $allServices[$service_type];

		$path ='/ical/';
		$fileName = 'booking_' . $service_type . '_' . $id . '.ics';
		$fullPath = $path.$fileName;

		$content  = $this->booking::getContentCalendarIcal($service_type,$id,$module);
		Storage::disk('uploads')->put($fullPath, $content);
		$file = Storage::disk('uploads')->get($fullPath);

		header('Content-Type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $fileName . '"');

		echo ($file);
	}


}
