<?php
use Illuminate\Support\Facades\Route;

Route::get('/','ContactController@index')->name('contact.admin.index');

Route::get('/edit/{id}', 'ContactController@edit')->name('contact.admin.edit');

Route::post('/store/{id}','ContactController@store')->name('contact.admin.store');
