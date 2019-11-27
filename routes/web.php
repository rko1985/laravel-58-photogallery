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

Route::get('/', 'AlbumsController@index');
Route::get('/albums', 'AlbumsController@index');
Route::get('/albums/create', 'AlbumsController@create')->name('album-create');
Route::post('/albums/store', 'AlbumsController@store')->name('album-store');
Route::get('albums/{id}', 'AlbumsController@show')->name('album-show');

Route::get('/photos/create/{albumId}', 'PhotosController@create')->name('photo-create');
Route::post('/photos/store', 'PhotosController@store')->name('photo-store');
Route::get('/photos/{id}', 'PhotosController@show')->name('photo-show');

Route::delete('/photos/{id}', 'PhotosController@destroy')->name('photo-destroy');