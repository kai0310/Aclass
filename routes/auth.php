<?php

use Illuminate\Support\Facades\Route;
use App\Level;

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
  Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
});

if(Level::count()<1){
  Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'Auth\RegisterController@register');
}else{
  Route::get('/new', function(){ return view('auth.new'); })->middleware('guest')->name('new');
  Route::post('/new', 'Auth\NewController@new')->middleware('guest');
}

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
