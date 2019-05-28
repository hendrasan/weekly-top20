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

Route::get('/', 'HomeController@getIndex')->name('home');

Route::get('/login/spotify', 'AuthSpotifyController@spotifyLogin')->name('login.spotify');
Route::get('/auth/spotify', 'AuthSpotifyController@spotifyCallback');

Route::get('/logout', 'AuthSpotifyController@getLogout')->name('logout');

Route::get('chart/{user}/{chartId?}', 'HomeController@getUserChart')->name('chart');

Route::get('dashboard', 'HomeController@getDashboard')->name('dashboard')->middleware('auth');
Route::get('rewind/2018', 'HomeController@getRewind2018')->name('rewind.2018')->middleware('auth');
Route::post('rewind/2018', 'HomeController@postRewind2018')->name('post.rewind.2018')->middleware('auth');

Route::get('rewind/{year}', 'HomeController@getRewind')->name('rewind')->middleware('auth');
Route::post('rewind/{year}', 'HomeController@postRewind')->name('post.rewind')->middleware('auth');
