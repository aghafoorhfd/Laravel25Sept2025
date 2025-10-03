<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Easypaisa callback (API)
Route::match(['get','post'],'/easypaisa/callback','\Modules\Booking\Controllers\BookingController@easypaisaCallback')->name('api.easypaisa.callback');