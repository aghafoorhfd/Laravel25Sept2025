<?php
use \Illuminate\Support\Facades\Route;
Route::get('/admin','DashboardController@index')->name('admin.index');

