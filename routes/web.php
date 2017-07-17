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

Route::resource('threads', 'ThreadController', ['only' => ['index', 'show', 'create', 'store']]);
Route::resource('threads.replies', 'ReplyController', ['only' => 'store']);

Route::get('/home', 'HomeController@index')->name('home');
