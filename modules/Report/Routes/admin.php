<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/1/2019
 * Time: 10:02 AM
 */
use Illuminate\Support\Facades\Route;

Route::get('booking/email_preview/{id}','BookingController@email_preview')->name('report.admin.booking.preview');
Route::post('booking/bulkEdit','BookingController@bulkEdit')->name('report.admin.booking.bulkEdit');



