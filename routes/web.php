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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::match(['get', 'post'], '/botman', 'BotManController@handle');



Route::get('webhook', function () {
    $botman = app('botman');
    $botman->verifyServices(env('TOKEN_VERIFY'));

//// give the bot something to listen for.
//    $botman->hears('hello', function (BotMan $bot) {
//        $bot->reply('Hello yourself.');
//    });
//
//// start listenin
//    $botman->listen();
});


