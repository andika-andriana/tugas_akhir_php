<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/baca','Biodata@baca');
Route::post('/simpan','Biodata@simpan');
Route::post('/ubah','Biodata@ubah');
Route::get('/hapus/{id}','Biodata@hapus');
Route::get('/bacaDetail/{id}','Biodata@bacaDetail');
