<?php

namespace App\Http\Controllers;

use app\Conversations\ExampleConversation;
use Mpociot\BotMan\BotMan;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');
        $botman->verifyServices(env('TOKEN_VERIFY'));
        // Simple respond method
        $botman->hears('Hello', function (BotMan $bot) {
            $bot->reply('Hi there :)');
        });

        $botman->hears('start', function (BotMan $bot) {
            $bot->startConversation(new ExampleConversation());
        });

        $botman->listen();
    }
    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }
}