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

Route::group(['middleware' => 'auth'], function () {
  Route::get('/', 'PostController@index')->name('posts');
  Route::get('/{group_id}/all', 'PostController@all')->name('postAll');
  Route::get('/{group_id}/{post_id}', 'PostController@single')->name('postSingle')->where(['group_id' => '[1-9]\d*', 'post_id' => '[1-9]\d*']);
});
