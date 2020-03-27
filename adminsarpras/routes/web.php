<?php

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

Route::get('/', function () {
    return redirect(route('login'));
});
Auth::routes();

Route::group(['middleware' => 'auth'], function(){
	// Middleware

Route::get('/rooms/edit/{room_id}/{user_id}', 'RoomController@editUser');
Route::resource('/rooms', 'RoomController')->except([
	'edit'
]);
Route::resource('/items', 'ItemController');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/user', 'UsersController')->except([
	'show', 'update'
]);
Route::get('user/approved/{id}', 'UsersController@approved');
Route::post('user/update', 'UsersController@updateUsers')->name('update-user');
Route::resource('/tipe', 'TipeController');
Route::resource('/satuan', 'SatuanController');
Route::resource('/report', 'ReportController')->except([
	'destroy', 'create', 'store', 'show'
]);
Route::put('/report/approve/{id}', 'ReportController@approve')->name('report.approve');
Route::resource('/borrow', 'ReturnBorrowItemController');
Route::get('borrow/edit-borrowed/{id}', 'ReturnBorrowItemController@editBorrowed');
Route::get('/return', 'ReturnBorrowItemController@pengembalian')->name('pengembalian');
Route::get('/return/detail/{id}', 'ReturnBorrowItemController@returnedDetail')->name('lihat');
Route::post('/borrow/returned', 'ReturnBorrowItemController@pengembalianBarang')->name('pengembalian-barang');

Route::get('/laporan', 'LaporanController@index')->name('laporan.index');
Route::get('/laporan/print/{id}', 'LaporanController@print')->name('laporan.print');

	// End Middleware
});
 