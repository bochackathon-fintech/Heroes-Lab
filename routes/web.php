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

Route::match(['get', 'post'], '/botman', 'BotManController@handle');

Route::get('webhook', 'AuthorizationController@verify');

Route::any('knock', 'BotManController@knock');
Route::any('getCookie', 'BotManController@getCookie');

Route::any('createuser','BotManController@createUser');

