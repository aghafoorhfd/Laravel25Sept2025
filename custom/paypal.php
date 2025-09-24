<?php

namespace Custom;

use Omnipay\Omnipay;

/**
 * Class PayPal
 * @package App
 */
class PayPal
{
    /**
     * @return mixed
     */
    public function gateway()
    {
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername(env('PAYPAL_SANDBOX_API_USERNAME', ''));
        $gateway->setPassword( env('PAYPAL_SANDBOX_API_PASSWORD', ''));
        $gateway->setSignature( env('PAYPAL_SANDBOX_API_SIGNATURE', ''));
        $gateway->setTestMode( env('PAYPAL_SANDBOX_TEST_MODE', ''));

        return $gateway;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function purchase(array $parameters)
    {
        $response = $this->gateway()
            ->purchase($parameters)
            ->send();

        return $response;
    }

    /**
     * @param array $parameters
     */
    public function complete(array $parameters)
    {
        $response = $this->gateway()
            ->completePurchase($parameters)
            ->send();

        return $response;
    }

    /**
     * @param $amount
     */
    public function formatAmount($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * @param $order
     */
    public function getCancelUrl($order)
    {
        return route('cancel.payment', $order->id);
    }

    /**
     * @param $order
     */
    public function getReturnUrl($order)
    {
        return route('success.payment', $order->id);
    }

    /**
     * @param $order
     */
    public function getNotifyUrl($order)
    {
        $env = env('PAYPAL_MODE', 'live');//config('paypal.credentials.sandbox') ? "sandbox" : "live";

        return route('payment.notify');
    }
}