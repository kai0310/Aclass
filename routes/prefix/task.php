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

  Route::get('/', 'TaskController@index')->name('tasks');
  Route::get('/{task_id}', 'TaskController@single')->name('taskSingle');
  Route::post('/{task_id}', 'TaskController@newSubmission');
  Route::get('/submission/all', 'TaskController@submissionAll')->name('submissionAll');
  Route::get('/submission/{submission_id}', 'TaskController@submissionSingle')->name('submissionSingle')->where('submission_id', '[1-9]\d*');

});
