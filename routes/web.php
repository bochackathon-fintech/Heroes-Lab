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

use Mpociot\BotMan\BotMan;
use Mpociot\BotMan\BotManFactory;
use Mpociot\BotMan\Cache\RedisCache;

Route::get('/', function () {
    return view('welcome');
});

Route::get('webhook', function () {
    $botman = app('botman');
    $botman->verifyServices('Bemqsiemens123123123123!');

//// give the bot something to listen for.
//    $botman->hears('hello', function (BotMan $bot) {
//        $bot->reply('Hello yourself.');
//    });
//
//// start listening
//    $botman->listen();
});
