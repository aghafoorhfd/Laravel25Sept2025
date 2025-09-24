<?php
use Illuminate\Support\Facades\Route;

Route::get('orders','OrderController@index')->name('booking.admin.order.index');
