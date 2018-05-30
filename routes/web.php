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
    return view('form.unggah');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/form/unggah', 'CrudController@create');
Route::post('/form/submit', 'CrudController@submit');
Route::get('/form/reset', 'CrudController@reset');
//Route::get('/form/tampil/', 'CrudController@tampil')->name('tampil');
