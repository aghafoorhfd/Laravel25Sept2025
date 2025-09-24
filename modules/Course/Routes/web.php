<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;
// Vendor Manage Course
Route::group(['prefix'=>'user/'.config('course.course_route_prefix')],function(){
    Route::match(['get','post'],'/','ManageCourseController@manageCourse')->name('course.vendor.index');
    Route::match(['get',],'/create','ManageCourseController@createCourse')->name('course.vendor.create');
    Route::match(['get',],'/edit/{id}','ManageCourseController@editCourse')->name('course.vendor.edit');
    Route::match(['get','post'],'/del/{id}','ManageCourseController@deleteCourse')->name('course.vendor.delete');
    Route::match(['post'],'/store/{id}','ManageCourseController@store')->name('course.vendor.store');
    Route::get('bulkEdit/{id}','ManageCourseController@bulkEditCourse')->name("course.vendor.bulk_edit");

    Route::get('clone/{id}','ManageCourseController@cloneCourse')->name("course.vendor.clone");


    Route::get('/orders','ManageCourseController@bookingReport')->name("course.vendor.orders");
    Route::get('/orders/bulkEdit/{id}','ManageCourseController@bookingReportBulkEdit')->name("course.vendor.orders.bulk_edit");

    Route::group(['prefix'=>'availability'],function(){
        Route::get('/','AvailabilityController@index')->name('course.vendor.availability.index');
        Route::get('/loadDates','AvailabilityController@loadDates')->name('course.vendor.availability.loadDates');
        Route::match(['get','post'],'/store','AvailabilityController@store')->name('course.vendor.availability.store');
    });

    Route::group(['prefix'=>'detail/{id}'],function (){
        Route::get('/lessons','LectureController@index')->name('course.vendor.lesson.index');
    });

});


// Course
Route::group(['prefix'=>config('course.course_route_prefix')],function(){
    Route::get('/','CourseController@index')->name('course.search'); // Search
    Route::get('/{slug}','CourseController@detail')->name('course.detail'); // Detail

    Route::get('/{slug}/study', 'StudyController@study')->name('course.study');// Learn
    Route::get('/scorm-player/{id}','ScormPlayerController@player')->name('course.scorm_player');
    Route::post('/study-log','StudyController@studyLog')->name('course.study-log')->middleware('auth');

});
