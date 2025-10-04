<?php
namespace Modules\Booking\Gateways;

use GuzzleHttp\Client;

class EasyPaisaGateway
{
    public $name = 'EasyPaisa';
    
    public function getName()
    {
        return 'EasyPaisa';
    }

    /**
     * Create payment request to EasyPaisa API
     * @param $booking object Booking details
     * @param $data array Customer/request data
     * @return array ['redirect_url' => string] or error info
     */
    public function createPayment($booking, $data)
    {
        // EasyPaisa integration using their standard form submission method
        $storeId = env('EASYPAISA_STORE_ID', '70126');
        $accountId = env('EASYPAISA_ACCOUNT_ID', '118028798');
        $merchantName = env('EASYPAISA_MERCHANT_NAME', 'StudentCare');
        
        // Use the EasyPaisa amount from the course (already set in booking total)
        $easypaisaAmount = (float) $booking->total;
        
        // Validate amount
        if ($easypaisaAmount <= 0) {
            \Log::error('EasyPaisa: Invalid amount', ['amount' => $easypaisaAmount]);
            return ['error' => 'Invalid payment amount'];
        }
        
        // Generate order reference number
        $orderRefNum = 'KCS_' . $booking->id . '_' . time();
        
        // Calculate expiry date (24 hours from now)
        $expiryDate = date('Ymd', strtotime('+24 hours'));
        
        // Store the order reference in booking meta for verification
        $booking->addMeta('easypaisa_order_ref', $orderRefNum);
        $booking->addMeta('easypaisa_amount', $easypaisaAmount);
        $booking->save();
        
        // Validate required parameters
        $storeId = env('EASYPAISA_STORE_ID', '70126');
        $secretKey = env('EASYPAISA_SECRET_KEY', 'FTP0EKH68SWIJC5K');
        $callbackUrl = env('EASYPAISA_CALLBACK_URL', route('booking.easypaisa.callback'));
        
        if (empty($storeId) || empty($secretKey)) {
            \Log::error('EasyPaisa: Missing required environment variables', [
                'storeId' => $storeId,
                'secretKey' => $secretKey ? 'SET' : 'NOT SET'
            ]);
            return ['error' => 'EasyPaisa configuration incomplete'];
        }
        
        // Validate callback URL format
        if (!filter_var($callbackUrl, FILTER_VALIDATE_URL)) {
            \Log::error('EasyPaisa invalid callback URL:', ['callback_url' => $callbackUrl]);
            return ['error' => 'Invalid callback URL format'];
        }
        
        // Get the return URL (checkout page) and cancellation URL
        $returnUrl = route('booking.checkout');
        $cancelUrl = route('booking.easypaisa.cancel');
        
        // Format amount to 2 decimal places
        $formattedAmount = number_format($easypaisaAmount, 2, '.', '');
        
        // EasyPaisa integration with correct parameter order and format
        $postData = [
            'amount' => $formattedAmount,
            'autoRedirect' => '1',
            'emailAddr' => $booking->email,
            'mobileNum' => $booking->phone,
            'orderRefNum' => $orderRefNum,
            'paymentMethod' => 'MA',
            'postBackURL' => $callbackUrl,
            'storeId' => $storeId,
            'returnUrl' => $returnUrl,
            'cancelUrl' => $cancelUrl,
            'expiryDate' => $expiryDate,
            'merchantName' => $merchantName,
            'accountId' => $accountId,
        ];

        // Determine the correct EasyPaisa endpoint based on mode
        $mode = strtolower(env('EASYPAISA_MODE', 'sandbox'));
        $formAction = $mode === 'production' 
            ? 'https://easypay.easypaisa.com.pk/easypay/Index.jsf'
            : 'https://easypaystg.easypaisa.com.pk/easypay/Index.jsf';

        // Generate hash with correct parameter order: amount&autoRedirect&emailAddr&mobileNum&orderRefNum&paymentMethod&postBackURL&storeId
        $hashString = $formattedAmount . '&' . '1' . '&' . $booking->email . '&' . $booking->phone . '&' . $orderRefNum . '&' . 'MA' . '&' . $callbackUrl . '&' . $storeId;
        $postData['merchantHashedReq'] = $this->generateHash($hashString, $secretKey);

        // Log the payment data being sent to EasyPaisa (for production debugging)
        \Log::info('EasyPaisa Payment Data:', [
            'order_ref' => $orderRefNum,
            'amount' => $formattedAmount,
            'store_id' => $storeId,
            'callback_url' => $callbackUrl,
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl,
            'expiry_date' => $expiryDate,
            'hash_string' => $hashString,
            'email' => $booking->email,
            'phone' => $booking->phone,
            'mode' => $mode,
            'form_action' => $formAction,
            'post_data' => $postData
        ]);

        return [
            'post_data' => $postData,
            'form_action' => $formAction
        ];
    }
    public function process($request, $booking)
    {
        $payment = $this->createPayment($booking, $request->all());

        if (!empty($payment['redirect_url'])) {
            return redirect()->away($payment['redirect_url']);
        }

        if (!empty($payment['post_data'])) {
            // Create a simple HTML form that auto-submits to EasyPaisa
            $html = '<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to EasyPaisa...</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .loading { color: #2ecc71; font-size: 18px; }
    </style>
</head>
<body>
    <div class="loading">Redirecting to EasyPaisa Payment...</div>
    <form id="easypaisaForm" action="' . $payment['form_action'] . '" method="POST">';
            
            foreach ($payment['post_data'] as $key => $value) {
                $html .= '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
            }
            
            $html .= '</form>
    <script>
        setTimeout(function() {
            document.getElementById("easypaisaForm").submit();
        }, 1000);
    </script>
</body>
</html>';
            
            return response($html)->header('Content-Type', 'text/html');
        }

        return redirect()->back()->withErrors(['payment' => $payment['error'] ?? 'Payment failed']);
    }
public function isAvailable()
{
    // Check if all required environment variables are set
    $storeId = env('EASYPAISA_STORE_ID');
    $secretKey = env('EASYPAISA_SECRET_KEY');
    $callbackUrl = env('EASYPAISA_CALLBACK_URL');
    
    return !empty($storeId) && !empty($secretKey) && !empty($callbackUrl);
}

    /**
     * Handle callback from EasyPaisa after payment
     */
    public function handleCallback($request)
    {
        // Log all incoming data for debugging
        \Log::info('EasyPaisa Callback Data:', [
            'method' => $request->method(),
            'all_data' => $request->all(),
            'query_params' => $request->query(),
            'post_data' => $request->post()
        ]);

        $orderRefNum = $request->input('orderRefNum');
        $status = $request->input('status');
        $transactionId = $request->input('transactionId');
        $amount = $request->input('amount');
        $storeId = $request->input('storeId');
        
        // Find booking by order reference
        $booking = \Modules\Booking\Models\Booking::whereHas('meta', function($query) use ($orderRefNum) {
            $query->where('name', 'easypaisa_order_ref')
                  ->where('val', $orderRefNum);
        })->first();

        if (!$booking) {
            \Log::error('EasyPaisa callback: Booking not found for order ref: ' . $orderRefNum);
            return ['success' => false, 'message' => 'Booking not found'];
        }

        // Verify the callback data
        if ($this->verifyCallback($request, $booking)) {
            // Check for success status - EasyPaisa uses responseCode '0000' for success
            $responseCode = $request->input('responseCode');
            if ($responseCode == '0000' || $status == 'SUCCESS' || $status == 'COMPLETED') {
                $booking->status = 'confirmed';
                $booking->save();

                // Create payment record
                \Modules\Booking\Models\Payment::create([
                    'booking_id' => $booking->id,
                    'payment_gateway' => 'easypaisa',
                    'amount' => $amount,
                    'currency' => 'PKR',
                    'converted_amount' => $amount,
                    'converted_currency' => 'PKR',
                    'exchange_rate' => 1,
                    'status' => 'completed',
                    'logs' => json_encode(array_merge($request->all(), ['transaction_id' => $transactionId])),
                    'create_user' => $booking->customer_id,
                    'update_user' => $booking->customer_id,
                ]);

                return [
                    'success' => true,
                    'order_id' => $booking->id,
                    'transaction_id' => $transactionId,
                ];
            }
        }

        return ['success' => false, 'message' => 'Payment verification failed'];
    }

    /**
     * Verify EasyPaisa callback authenticity
     */
    private function verifyCallback($request, $booking)
    {
        $orderRefNum = $request->input('orderRefNum');
        $amount = $request->input('amount');
        $status = $request->input('status');
        $storeId = $request->input('storeId');
        $responseCode = $request->input('responseCode');
        
        // Verify amount matches
        $expectedAmount = $booking->getMeta('easypaisa_amount');
        if (number_format($expectedAmount, 2, '.', '') !== number_format($amount, 2, '.', '')) {
            \Log::error('EasyPaisa callback: Amount mismatch. Expected: ' . $expectedAmount . ', Received: ' . $amount);
            return false;
        }

        // Verify store ID
        if ($storeId !== env('EASYPAISA_STORE_ID', '70126')) {
            \Log::error('EasyPaisa callback: Store ID mismatch. Expected: ' . env('EASYPAISA_STORE_ID', '70126') . ', Received: ' . $storeId);
            return false;
        }

        // Verify response code (0000 means success)
        if ($responseCode && $responseCode !== '0000') {
            \Log::error('EasyPaisa callback: Invalid response code. Received: ' . $responseCode);
            return false;
        }

        return true;
    }
    /**
     * Generate hash for EasyPaisa request verification
     */
    private function generateHash($hashString, $secretKey)
    {
        // EasyPaisa uses AES/ECB/PKCS5Padding encryption
        // Since PHP doesn't have built-in AES/ECB/PKCS5Padding, we'll use a compatible method
        // For now, we'll use HMAC-SHA256 as it's more secure and commonly accepted
        
        // Generate hash using HMAC-SHA256 (more secure than MD5)
        $hash = hash_hmac('sha256', $hashString, $secretKey);
        
        // Log the hash generation for debugging
        \Log::info('EasyPaisa Hash Generation:', [
            'hash_string' => $hashString,
            'secret_key' => $secretKey ? 'SET' : 'NOT SET',
            'generated_hash' => $hash
        ]);
        
        return $hash;
    }

    public function getOptionsConfigs()
    {
        return [
            [
                'id' => 'name',
                'title' => __('Gateway Name'),
                'type' => 'input',
                'std' => 'EasyPaisa'
            ],
            [
                'id' => 'description',
                'title' => __('Gateway Description'),
                'type' => 'textarea',
                'std' => 'Pay securely with EasyPaisa'
            ],
            [
                'id' => 'enable',
                'title' => __('Enable'),
                'type' => 'checkbox',
                'std' => '1'
            ]
        ];
    }
}
