<?php
use Illuminate\Support\Facades\Route;

Route::get('/','CourseController@index')->name('course.admin.index');

Route::match(['get'],'/create','CourseController@create')->name('course.admin.create');
Route::match(['get'],'/edit/{id}','CourseController@edit')->name('course.admin.edit');

Route::post('/store/{id}','CourseController@store')->name('course.admin.store');

Route::get('/getForSelect2','CourseController@getForSelect2')->name('course.admin.getForSelect2');
Route::post('/bulkEdit','CourseController@bulkEdit')->name('course.admin.bulkEdit');

Route::match(['get'],'/category','CategoryController@index')->name('course.admin.category.index');
Route::match(['get'],'/category/edit/{id}','CategoryController@edit')->name('course.admin.category.edit');
Route::match(['get', 'post'],'/category/editBulk','CategoryController@editBulk')->name('course.admin.category.editBulk');
Route::post('/category/store/{id}','CategoryController@store')->name('course.admin.category.store');
Route::get('/category/getForSelect2','CategoryController@getForSelect2')->name('course.admin.category.getForSelect2');

Route::group(['prefix'=>'attribute'],function (){
    Route::get('/','AttributeController@index')->name('course.admin.attribute.index');
    Route::get('edit/{id}','AttributeController@edit')->name('course.admin.attribute.edit');
    Route::post('store/{id}','AttributeController@store')->name('course.admin.attribute.store');
    Route::post('editAttrBulk','AttributeController@editAttrBulk')->name('course.admin.attribute.editAttrBulk');

    Route::get('terms/{id}','AttributeController@terms')->name('course.admin.attribute.term.index');
    Route::get('term_edit/{id}','AttributeController@term_edit')->name('course.admin.attribute.term.edit');
    Route::post('term_store','AttributeController@term_store')->name('course.admin.attribute.term.store');
    Route::post('editTermBulk','AttributeController@editTermBulk')->name('course.admin.attribute.term.editTermBulk');

    Route::get('getForSelect2','AttributeController@getForSelect2')->name('course.admin.attribute.term.getForSelect2');
    Route::get('getAttributeForSelect2','AttributeController@getAttributeForSelect2')->name('course.admin.attribute.getForSelect2');
});

Route::group(['prefix'=>'section'],function (){
    Route::get('getForSelect2','SectionController@getForSelect2')->name('course.admin.section.lesson.getForSelect2');
    Route::get('getSectionForSelect2','SectionController@getSectionForSelect2')->name('course.admin.section.getForSelect2');

    Route::get('{course_id}/index','SectionController@index')->name('course.admin.section.index');
    Route::get('{course_id}/edit/{id}','SectionController@edit')->name('course.admin.section.edit');
    Route::post('{course_id}/store/{id}','SectionController@store')->name('course.admin.section.store');
    Route::post('{course_id}/editSectionBulk','SectionController@editSectionBulk')->name('course.admin.section.editSectionBulk');

    Route::get('{course_id}/lessons/{id}','SectionController@lessons')->name('course.admin.section.lesson.index');
    Route::get('{course_id}/lesson_edit/{id}','SectionController@lesson_edit')->name('course.admin.section.lesson.edit');
    Route::post('{course_id}/editLessonBulk','SectionController@editLessonBulk')->name('course.admin.section.lesson.editLessonBulk');
    Route::post('{course_id}/lesson_store','SectionController@lesson_store')->name('course.admin.section.lesson.store');
});


Route::group(['prefix'=>'detail/{id}'],function (){
    Route::get('/lessons','LectureController@index')->name('course.admin.lesson.index');
    Route::post('/lessons/store','LectureController@store')->name('course.admin.lesson.store');
    Route::post('/sections/store','SectionController@store_ajax')->name('course.admin.section.store');
});


Route::get('/tag','TagController@index')->name('course.admin.tag.index');
Route::post('/tag/bulkEdit','CourseController@bulkEdit')->name('course.admin.tag.bulkEdit');

Route::get('/tag/edit/{id}','TagController@edit')->name('course.admin.tag.edit');
Route::post('/tag/store/{id}','TagController@store')->name('course.admin.tag.store');
