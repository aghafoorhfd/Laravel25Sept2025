<?php
namespace Modules\Booking\Gateways;

use GuzzleHttp\Client;

class EasyPaisaGateway
{
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
        $client = new Client();

        // Prepare your API payload according to EasyPaisa's API docs
        $payload = [
            'merchant_id' => env('EASYPASA_MERCHANT_ID'),
            'amount' => $booking->total_amount,
            'callback_url' => env('EASYPASA_CALLBACK_URL'),
            'customer_phone' => $data['phone'] ?? '',
            'customer_name' => $data['first_name'] . ' ' . $data['last_name'],
            'order_id' => $booking->id,
            // add other required fields
        ];

        try {
            $response = $client->post('https://api.easypaisa.com/payment/create', [
                'json' => $payload,
                'headers' => [
                    'Authorization' => 'Bearer ' . env('EASYPASA_API_KEY'),
                    'Accept' => 'application/json',
                ],
            ]);

            $body = json_decode($response->getBody(), true);

            if (!empty($body['payment_url'])) {
                return ['redirect_url' => $body['payment_url']];
            }

            return ['error' => $body['message'] ?? 'Unable to create payment'];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function process($request, $booking)
{
    $payment = $this->createPayment($booking, $request->all());

    if (!empty($payment['redirect_url'])) {
        return redirect()->away($payment['redirect_url']);
    }

    return redirect()->back()->withErrors(['payment' => $payment['error'] ?? 'Payment failed']);
}
public function isAvailable()
{
    // You can add real checks here, like config keys or API connectivity
    return env('EASYPASA_API_KEY') && env('EASYPASA_MERCHANT_ID') && env('EASYPASA_CALLBACK_URL');
}

    /**
     * Handle callback from EasyPaisa after payment
     */
    public function handleCallback($request)
    {
        // You need to verify the signature and payment status from $request data

        $paymentStatus = $request->input('status'); // example field
        $orderId = $request->input('order_id');

        // Verify signature here if EasyPaisa requires (depends on their docs)

        if ($paymentStatus == 'SUCCESS') {
            return [
                'success' => true,
                'order_id' => $orderId,
                'transaction_id' => $request->input('transaction_id'),
                // other info
            ];
        }

        return ['success' => false];
    }
    public function getOptionsConfigs()
{
    return [];
}
}
