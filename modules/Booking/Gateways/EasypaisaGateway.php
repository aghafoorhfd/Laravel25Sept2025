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
        
        // Generate order reference number
        $orderRefNum = 'KCS_' . $booking->id . '_' . time();
        
        // Calculate expiry date (24 hours from now)
        $expiryDate = date('Ymd', strtotime('+24 hours'));
        
        // Store the order reference in booking meta for verification
        $booking->addMeta('easypaisa_order_ref', $orderRefNum);
        $booking->addMeta('easypaisa_amount', $booking->total);
        $booking->save();
        
        // EasyPaisa integration using environment variables
        $postData = [
            'amount' => number_format($booking->total, 2, '.', ''),
            'storeId' => env('EASYPAISA_STORE_ID', '70126'),
            'postBackURL' => env('EASYPAISA_CALLBACK_URL', route('booking.confirmPayment', ['gateway' => 'easypaisa'])),
            'orderRefNum' => $orderRefNum,
            'expiryDate' => $expiryDate,
            'autoRedirect' => '1',
            'merchantHashedReq' => $this->generateHash(env('EASYPAISA_STORE_ID', '70126'), $orderRefNum, $booking->total, $expiryDate),
            'paymentMethod' => 'MA',
        ];

        // Debug: Log the payment data being sent to EasyPaisa
        \Log::info('EasyPaisa Payment Data:', $postData);

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
    // For now, return true to allow testing. In production, add proper checks:
    // return env('EASYPAISA_API_KEY') && env('EASYPAISA_MERCHANT_ID') && env('EASYPAISA_CALLBACK_URL');
    return true;
}

    /**
     * Handle callback from EasyPaisa after payment
     */
    public function handleCallback($request)
    {
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
        $hashString = $storeId . '&' . $orderRefNum . '&' . number_format($amount, 2, '.', '') . '&' . $expiryDate;
        $secretKey = env('EASYPAISA_SECRET_KEY', 'test_secret_key_for_local');
        
        // Generate hash using the secret key from environment
        return md5($hashString . $secretKey);
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
