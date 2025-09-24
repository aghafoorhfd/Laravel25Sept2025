<?php
use Illuminate\Support\Facades\Route;
// Booking
Route::get('/cart','BookingController@cart')->name('booking.cart')->middleware('auth');
Route::get('/checkout','BookingController@checkout')->name('booking.checkout')->middleware('auth');

Route::group(['prefix'=>config('booking.booking_route_prefix'),'middleware'=>['auth']],function(){
    Route::post('/addToCart','BookingController@addToCart')->name('booking.addToCart');
    Route::post('/remove_cart_item','BookingController@removeCartItem')->name('booking.remove_cart_item');
    Route::get('/cart','BookingController@cart');
    Route::post('/doCheckout','BookingController@doCheckout');
    Route::get('/confirm/{gateway}','BookingController@confirmPayment');
    Route::get('/cancel/{gateway}','BookingController@cancelPayment');
    Route::get('/{code}','BookingController@detail')->name('booking.detail');
    Route::get('/{code}/checkout','BookingController@checkout');
    Route::get('/{code}/check-status','BookingController@checkStatusCheckout');

//    ical
	Route::get('/export-ical/{type}/{id}','BookingController@exportIcal')->name('booking.admin.export-ical');
});
