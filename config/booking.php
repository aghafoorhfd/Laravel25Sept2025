<?php
return [
    'booking_route_prefix'=>env("BOOKING_ROUTER_PREFIX",'booking'),
    'services'=>[
    ],
    'payment_gateways'=>[
        // 'offline_payment'=>Modules\Booking\Gateways\OfflinePaymentGateway::class,
        'paypal'=>Modules\Booking\Gateways\PaypalGateway::class,
        'stripe'=>Modules\Booking\Gateways\StripeGateway::class,
        'easypaisa'=>Modules\Booking\Gateways\EasypaisaGateway::class
    ],
    'statuses'=>[
        'completed',
        'processing',
        'confirmed',
        'cancelled',
        'paid',
        'unpaid',
    ]
];
