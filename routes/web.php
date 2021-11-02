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

Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::get('/logout', 'App\Http\Controllers\LoginController@logout')->name('logout');

# Solo invitados
Route::middleware('guest')->group(function (){
    Route::get('/login', 'App\Http\Controllers\LoginController@index')->name('login');
    Route::get('/register', 'App\Http\Controllers\RegisterController@index')->name('register');
});


Route::get('/auth/login/{token}', 'App\Http\Controllers\LoginController@loginToken');
