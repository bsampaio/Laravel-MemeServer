<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('image/{token}', [
    'as'    => 'image.get',
    'uses'  => 'ImageController@get'
])->where('token', '^201[5-6]((0[1-9])|(1[0-2]))((3[0-1])|([1-2][1-9]))((2[0-3])|([0-1][0-9]))([0-5][0-9])([0-5][0-9]).{4}$');

Route::post('image',[
   'as'     => 'image.store',
   'uses'   => 'ImageController@store'
]);

Route::get('image/list', [
    'as'    => 'image.list',
    'uses'  => 'ImageController@all'
]);

Route::get('image', [
    'as'    => 'image.index',
    'uses'  => 'ImageController@index'
]);