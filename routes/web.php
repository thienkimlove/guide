<?php

#Admin Routes
Route::get('admin/login', 'AdminController@redirectToGoogle');
Route::get('admin/logout', 'AdminController@logout');
Route::get('admin/callback', 'AdminController@handleGoogleCallback');
Route::get('admin/notice', 'AdminController@notice');
Route::get('admin', 'AdminController@index');
#Content Routes
foreach (config('site.content') as $content => $config) {
    Route::resource('admin/'.$content, 'ContentsController');
}

#Frontend Routes

Route::get('/', 'FrontendController@index');
Route::get('lien-he', 'FrontendController@contact');
Route::get('video/{value?}', 'FrontendController@video');
Route::get('phan-phoi/{value?}', 'FrontendController@delivery');
Route::post('save_question', 'FrontendController@saveQuestion');
Route::get('tag/{value}', 'FrontendController@tag');
Route::get('search', 'FrontendController@search');
Route::get('product/{value?}', 'FrontendController@product');
Route::get('hoi-dap/{value?}', 'FrontendController@question');
Route::get('{value}', 'FrontendController@main');