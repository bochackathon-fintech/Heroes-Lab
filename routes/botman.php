<?php

// Don't use the Facade in here to support the RTM API too :)
use App\Http\Controllers\BotManController;

$botman = resolve('botman');
$botman->hears('test', function($bot){
    $bot->reply('hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears(config('services.botman.facebook_start_button_payload'),BotManController::class.'@startConversation');