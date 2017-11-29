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

Route::get('/', 'HomeController@index');

Route::get('/manageCourses', function () {
	return view('manageCourses');
});

Route::get('/manageFriends', function () {
	return view('manageFriends');
});

Route::get('/findFriendBreaks', function () {
    return view('findFriendBreaks');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/manageFriends', 'FriendController@friends');

