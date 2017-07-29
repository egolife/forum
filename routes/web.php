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

Route::get('/', 'ThreadController@index');

Auth::routes();
Route::get('impersonate/take/{user}', 'ImpersonateController@take')->name('impersonate');
Route::get('impersonate/leave', 'ImpersonateController@leave')->name('impersonate.leave');

Route::get('threads', 'ThreadController@index')->name('threads.index');
Route::get('threads/create', 'ThreadController@create')->name('threads.create');
Route::get('threads/{channel}', 'ThreadController@index')->name('channels.show');
Route::get('threads/{channel}/{thread}', 'ThreadController@show')->name('threads.show');
Route::post('threads', 'ThreadController@store')->name('threads.store');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy')->name('threads.destroy');

Route::get('threads/{channel}/{thread}/replies', 'ReplyController@index')->name('replies.index');
Route::post('threads/{channel}/{thread}/replies', 'ReplyController@store')->name('replies.store');
Route::post('threads/{channel}/{thread}/subscriptions',
    'ThreadSubscriptionController@store')->name('subscription.store');
Route::delete('threads/{channel}/{thread}/subscriptions',
    'ThreadSubscriptionController@destroy')->name('subscription.destroy');

Route::get('/home', 'HomeController@index')->name('home');

Route::delete('replies/{reply}', 'ReplyController@destroy')->name('replies.destroy');
Route::patch('replies/{reply}', 'ReplyController@update')->name('replies.update');
Route::post('/replies/{reply}/favorites', 'FavoriteController@store')->name('favorites.store');
Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroy')->name('favorites.destroy');

Route::get('/profiles/{user}', 'ProfileController@show')->name('profiles.show');
Route::get('/profiles/{user}/notifications', 'UserNotificationController@index')
    ->name('notifications.index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationController@destroy')
    ->name('notifications.destroy');