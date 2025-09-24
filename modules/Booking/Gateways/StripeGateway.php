<?php
namespace Modules\Booking\Gateways;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;

class StripeGateway
{
    public $name = 'Stripe';

    // or if you prefer method:
    public function getName()
    {
        return 'Stripe';
    }
    protected $gateway_id;

    public function __construct($gateway_id)
    {
        $this->gateway_id = $gateway_id;
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function isAvailable()
    {
        return env('STRIPE_KEY') && env('STRIPE_SECRET');
    }

    public function process(Request $request, $booking)
    {
        // You can do server-side payment with Stripe PaymentIntents API

        try {
            // Create PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => intval($booking->total * 100), // amount in cents
                'currency' => 'usd', // use your currency
                'metadata' => [
                    'booking_id' => $booking->id,
                    'customer_email' => $booking->email,
                ],
                // You can add more options like payment_method_types etc
            ]);

            // Save PaymentIntent ID to booking meta (optional)
            $booking->addMeta('stripe_payment_intent', $paymentIntent->id);

            // Return client secret to frontend for Stripe.js
            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'booking_code' => $booking->code,
                'redirect_url' => route('booking.detail', ['code' => $booking->code])
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function confirmPayment(Request $request)
    {
        // Handle webhook or post-payment confirmation if needed
    }

    public function cancelPayment(Request $request)
    {
        // Handle cancel if needed
    }
public function getOptionsConfigs()
{
    return [];
}
}
