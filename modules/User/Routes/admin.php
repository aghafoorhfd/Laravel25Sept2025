<?php
use \Illuminate\Support\Facades\Route;

Route::get('/getForSelect2','UserController@getForSelect2')->name('user.admin.getForSelect2');
Route::get('/','UserController@index')->name('user.admin.index');
Route::get('/create','UserController@create')->name('user.admin.create');
Route::get('/edit/{id}','UserController@edit')->name('user.admin.detail');
Route::post('/store/{id}','UserController@store')->name('user.admin.store');
Route::post('/bulkEdit','UserController@bulkEdit')->name('user.admin.bulkEdit');

Route::get('/userUpgradeRequest','UserController@userUpgradeRequest')->name('user.admin.userUpgradeRequest');
Route::post('/userUpgradeRequestApproved','UserController@userUpgradeRequestApproved')->name('user.admin.userUpgradeRequestApproved');


Route::group(['prefix'=>'role'],function (){
    Route::get('/','RoleController@index')->name('user.admin.role.index');
    Route::get('/verifyFields','RoleController@verifyFields')->name('user.admin.role.verifyFields');
    Route::get('/edit/{id}','RoleController@edit')->name('user.admin.role.detail');
    Route::post('/store/{id}','RoleController@store')->name('user.admin.role.store');
    Route::post('/verifyFieldsStore','RoleController@verifyFieldsStore')->name('user.admin.role.verifyFieldsStore');
    Route::get('/verifyFieldsEdit/{id}','RoleController@verifyFieldsEdit')->name('user.admin.role.verifyFieldsEdit');
});

Route::group(['prefix'=>'verification'],function (){
    Route::get('/','VerificationController@index')->name('user.admin.verification.index');
    Route::get('detail/{id}','VerificationController@detail')->name('user.admin.verification.detail');
    Route::post('store/{id}','VerificationController@store')->name('user.admin.verification.store');
});

