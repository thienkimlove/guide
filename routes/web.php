<?php

#Admin Routes
Route::get('admin/login', 'AdminController@redirectToGoogle');
Route::get('admin/logout', 'AdminController@logout');
Route::get('admin/callback', 'AdminController@handleGoogleCallback');
Route::get('admin/notice', 'AdminController@notice');
Route::get('admin', 'AdminController@index');
#Content Routes
foreach (config('site.content') as $content => $config) {
    Route::resource('admin/'.$content, ucfirst($content).'Controller');
}

#Frontend Routes
Route::get('/', 'FrontendController@index');