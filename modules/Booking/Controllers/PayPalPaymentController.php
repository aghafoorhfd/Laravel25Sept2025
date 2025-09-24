<?php
namespace Modules\Booking\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;
use Custom\PayPal;

class PayPalPaymentController extends \App\Http\Controllers\Controller
{
    public $order;

    public function __construct()
    {
        $this->order = (object) array('id' => '1','amount'=>1);
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $order_id = $this->order->id;

        $order = $this->order;

        return view('Booking::booking.index', compact('order'));
    }

    /**
     * @param $order_id
     * @param Request $request
     */
    public function handlePayment(Request $request)
    {
        $order = $this->order;

        $paypal = new PayPal;

        $response = $paypal->purchase([
            'amount' => $paypal->formatAmount($order->amount),
            'transactionId' => $order->id,
            'currency' => 'USD',
            'cancelUrl' => $paypal->getCancelUrl($order),
            'returnUrl' => $paypal->getReturnUrl($order),
        ]);

        if ($response->isRedirect()) {
            $response->redirect();
        }

        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    /**
     * @param $order_id
     * @param Request $request
     * @return mixed
     */
    public function paymentSuccess(Request $request)
    {
        $order = $this->order;

        $paypal = new PayPal;

        $response = $paypal->complete([
            'amount' => $paypal->formatAmount($order->amount),
            'transactionId' => $order->id,
            'currency' => 'USD',
            'cancelUrl' => $paypal->getCancelUrl($order),
            'returnUrl' => $paypal->getReturnUrl($order),
            'notifyUrl' => $paypal->getNotifyUrl($order),
        ]);

        if ($response->isSuccessful()) {
            // $order->update(['transaction_id' => $response->getTransactionReference()]);
            echo "You recent payment is sucessful with reference code " . $response->getTransactionReference(); die;
            return redirect()->route('app.home', encrypt($order_id))->with([
                'message' => 'You recent payment is sucessful with reference code ' . $response->getTransactionReference(),
            ]);
        }
        die('Completed error');
        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    /**
     * @param $order_id
     */
    public function paymentCancel()
    {
        echo "You have cancelled your recent PayPal payment !"; die;
        $order = $this->order;

        return redirect()->route('app.home', encrypt($order_id))->with([
            'message' => 'You have cancelled your recent PayPal payment !',
        ]);
    }

    /**
     * @param $order_id
     * @param $env
     */
    public function webhook(Request $request)
    {
        print_r($request); die;
        // to do with next blog post
    }
}
