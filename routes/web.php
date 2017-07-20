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
    return view('welcome');
});

Auth::routes();
Route::get('impersonate/take/{user}', 'ImpersonateController@take')->name('impersonate');
Route::get('impersonate/leave', 'ImpersonateController@leave')->name('impersonate.leave');

Route::get('threads', 'ThreadController@index')->name('threads.index');
Route::get('threads/create', 'ThreadController@create')->name('threads.create');
Route::get('threads/{channel}', 'ThreadController@index')->name('channels.show');
Route::get('threads/{channel}/{thread}', 'ThreadController@show')->name('threads.show');
Route::post('threads', 'ThreadController@store')->name('threads.store');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy')->name('threads.destroy');

Route::post('threads/{channel}/{thread}/replies', 'ReplyController@store')->name('replies.store');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/replies/{reply}/favorites', 'FavoriteController@store')->name('favorites.store');

Route::get('/profiles/{user}', 'ProfileController@show')->name('profiles.show');