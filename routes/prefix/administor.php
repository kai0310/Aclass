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

Route::group(['middleware' => ['auth', 'administor']], function () {

  Route::get('/', function(){ return view('pages.administors.index'); })->name('administor');

  Route::get('/changeLevel', 'Administor\LevelController@changeForm')->name('changeLevel');
  Route::post('/changeLevel', 'Administor\LevelController@change');

  Route::get('/register', function(){ return view('pages.administors.registers.register'); })->name('registerUser');
  Route::post('/register', 'Administor\RegisterController@create');

});
