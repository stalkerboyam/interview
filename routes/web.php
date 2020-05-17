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

Route::get('/', 'TripController@index')->name('home');
Route::post('/search', 'TripController@search')->name('search');
Route::get('/trips/{id}', 'TripController@trip_detail')->name('trip-detail');
Route::get('/search', function (){
    abort(404);
});
