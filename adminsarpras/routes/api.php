<?php

use Illuminate\Http\Request;

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
 
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::post('additem', 'UserController@addItem');
Route::post('edititem', 'UserController@editItem');
Route::post('show/{id}', 'UserController@show');
Route::post('logout', 'UserController@logout');
Route::post('load', 'UserController@checkSession');
Route::post('getitem/{id}', 'UserController@getItem');
Route::post('delete/{id}', 'UserController@deleteItem');
Route::post('showroom', 'UserController@room');
Route::post('barcode/{id}/{idUser}', 'UserController@barcode');
Route::post('addreport', 'UserController@addReport');
Route::post('getallreport', 'UserController@getAllReport');
Route::post('getonereport', 'UserController@getOneReport');

