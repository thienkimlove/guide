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
Route::resource('admin/modules', 'ModulesController');

Route::get('contentAjax', 'ContentsController@ajax');

#Frontend Routes
Route::get('/', 'FrontendController@index');
Route::get('/ajax', 'FrontendController@ajax');
Route::get('/ajaxChamp/{id}', 'FrontendController@ajaxChamp');
Route::get('/champion/{value}', 'FrontendController@character');
Route::get('{value}', 'FrontendController@main');