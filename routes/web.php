<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ImageController@index');

Route::post('uploadimage', 'ImageController@uploadImage');
Route::get('loadjson', 'ImageController@loadJson');
Route::get('removeimage/{imageId}', 'ImageController@removeImage');