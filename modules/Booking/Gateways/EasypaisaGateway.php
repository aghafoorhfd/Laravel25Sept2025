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
        
        // Get the return URL (checkout page) and cancellation URL
        $returnUrl = route('booking.checkout');
        $cancelUrl = route('booking.easypaisa.cancel');
        
        // EasyPaisa integration using environment variables
        $postData = [
            'amount' => number_format($easypaisaAmount, 2, '.', ''),
            'storeId' => $storeId,
            'postBackURL' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'cancelUrl' => $cancelUrl,
            'orderRefNum' => $orderRefNum,
            'expiryDate' => $expiryDate,
            'autoRedirect' => '1',
            'merchantHashedReq' => $this->generateHash($storeId, $orderRefNum, $easypaisaAmount, $expiryDate),
            'paymentMethod' => 'MA',
        ];

        // Log the payment data being sent to EasyPaisa (for production debugging)
        \Log::info('EasyPaisa Payment Data:', [
            'order_ref' => $orderRefNum,
            'amount' => $easypaisaAmount,
            'store_id' => $storeId,
            'callback_url' => $callbackUrl,
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl,
            'expiry_date' => $expiryDate
        ]);

        return [
            'post_data' => $postData,
            'form_action' => 'https://easypay.easypaisa.com.pk/easypay/Index.jsf'
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
            if ($status == 'SUCCESS' || $status == 'COMPLETED') {
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

        return true;
    }
    /**
     * Generate hash for EasyPaisa request verification
     */
    private function generateHash($storeId, $orderRefNum, $amount, $expiryDate)
    {
        // Format amount to 2 decimal places
        $formattedAmount = number_format($amount, 2, '.', '');
        
        // Create hash string in the order: storeId&orderRefNum&amount&expiryDate
        $hashString = $storeId . '&' . $orderRefNum . '&' . $formattedAmount . '&' . $expiryDate;
        $secretKey = env('EASYPAISA_SECRET_KEY', 'FTP0EKH68SWIJC5K');
        
        // Generate hash using MD5
        $hash = md5($hashString . $secretKey);
        
        // Log the hash generation for debugging
        \Log::info('EasyPaisa Hash Generation:', [
            'store_id' => $storeId,
            'order_ref' => $orderRefNum,
            'amount' => $formattedAmount,
            'expiry_date' => $expiryDate,
            'hash_string' => $hashString,
            'secret_key' => $secretKey,
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
