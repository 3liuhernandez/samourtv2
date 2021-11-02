<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

# Rutas para uuario logeado
Route::middleware('auth:api')->group(function (){
    # Obtiene los datos del usuario
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    # CRUD usuarios
    Route::resource('/users', App\Http\Controllers\Api\UsersController::class);

    # CRUD categorías
    Route::resource('/categories', App\Http\Controllers\Api\CategoryController::class);

    # CRUD Productos
    Route::resource('/products', App\Http\Controllers\Api\ProductController::class);
});


Route::post('/logout', 'App\Http\Controllers\Api\AuthController@logout');

Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');

