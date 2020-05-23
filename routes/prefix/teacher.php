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

Route::group(['middleware' => ['auth', 'teacher']], function () {

  Route::get('/', function(){ return view('pages.teachers.index'); })->name('teacher');

  Route::group(['prefix' => 'post'], function(){
    Route::get('/', 'Teacher\PostController@form')->name('post');
    Route::get('/new', 'Teacher\PostController@form')->name('newPost');
    Route::post('/new', 'Teacher\PostController@new');
  });

  Route::group(['prefix' => 'task'], function(){
    Route::get('/', function(){return view('pages.teachers.task.index');})->name('task');
    Route::get('/all', 'Teacher\TaskController@all')->name('taskAll');
    Route::get('/new', 'Teacher\TaskController@form')->name('newTask');
    Route::post('/new', 'Teacher\TaskController@new');
    Route::get('/{task}/submission/all', 'Teacher\TaskController@submissionAll')->where(['task', '[1-9]\d*'])->name('submissionCheckAll');
    Route::get('/{task}/submission/{submission}', 'Teacher\TaskController@submission')->where([
      'task' => '[1-9]\d*',
      'submission' => '[1-9]\d*'
      ])->name('submissionCheck');
    });

    Route::group(['prefix' => 'group'], function(){
      Route::get('/', function(){return view('pages.teachers.groups.index');})->name('group');
      Route::get('/new', function(){return view('pages.teachers.groups.new');})->name('newGroup');
      Route::post('/new', 'Teacher\GroupController@new');
      Route::get('/all', 'Teacher\GroupController@all')->name('groupAll');
      Route::get('/{group}', 'Teacher\GroupController@single')->where(['group', '[1-9]\d*'])->name('groupSingle');
      Route::post('/{group}/new', 'Teacher\GroupController@newUser')->where(['group', '[1-9]\d*'])->name('groupNewUser');
      Route::post('/{group}/delete', 'Teacher\GroupController@deleteUser')->where(['group', '[1-9]\d*'])->name('groupDeleteUser');
    });
  });
