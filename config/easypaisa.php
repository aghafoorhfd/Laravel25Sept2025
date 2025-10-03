<?php

return [
	'store_id' => env('EASYPAISA_STORE_ID'),
	'account_id' => env('EASYPAISA_ACCOUNT_ID'),
	'merchant_name' => env('EASYPAISA_MERCHANT_NAME'),
	'secret_key' => env('EASYPAISA_SECRET_KEY'),
	'mode' => env('EASYPAISA_MODE', 'sandbox'),
	'base_url' => env('EASYPAISA_BASE_URL', 'https://easypaystg.easypaisa.com.pk/easypay-service/rest'),
	'currency' => env('EASYPAISA_CURRENCY', 'PKR'),
	'payment_method' => env('EASYPAISA_PAYMENT_METHOD', 'MA'),
	'return_url' => env('EASYPAISA_RETURN_URL'),
	'cancel_url' => env('EASYPAISA_CANCEL_URL'),
	'callback_url' => env('EASYPAISA_CALLBACK_URL'),
];


