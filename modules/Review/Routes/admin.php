<?php
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'],'/','ReviewController@index')->name('review.admin.index');

Route::match(['get'],'/create','ReviewController@create')->name('review.admin.create');
Route::match(['get'],'/edit/{id}','ReviewController@edit')->name('review.admin.edit');

Route::post('/store/{id}','ReviewController@store')->name('review.admin.store');

Route::get('/getForSelect2','ReviewController@getForSelect2')->name('review.admin.getForSelect2');
Route::post('/bulkEdit','ReviewController@bulkEdit')->name('review.admin.bulkEdit');

