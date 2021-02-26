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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('libros/nuevo', 'BookController@create');
    Route::post('prestar/{user}/{book}', 'LendController@add');
});

Route::get('libros', 'BookController@index');
Route::post('login', 'UserController@authenticate');
Route::get('libros/{book}', 'BookController@show');


Route::post('usuarios/nuevo', 'UserController@register');
