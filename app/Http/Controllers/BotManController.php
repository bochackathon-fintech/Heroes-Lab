<?php

namespace App\Http\Controllers;

use App\Conversations\StartConversation;
use App\Custom\EnrichMessage;
use GuzzleHttp;
use Mpociot\BotMan\BotMan;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        //get botman
        $botman = app('botman');
        $botman->verifyServices(env('TOKEN_VERIFY'));

        //basic functionality for auth users
        $botman->hears('Hello', function (BotMan $bot) {
            $bot->reply('Hi there :)');
        });

        $botman->hears('start', function (BotMan $bot) {
            $bot->startConversation(new StartConversation());
        })->middleware(new EnrichMessage());

        //user clicked get started button
        $botman->hears(config('services.botman.facebook_start_button_payload'), function (BotMan $bot) {
            $bot->startConversation(new StartConversation());
        })->middleware(new EnrichMessage());

        //list to user
        $botman->listen();
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new StartConversation());
    }

    public function getCookie() {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://usdledger.online/api/auth/login', array(
            'content-type' => 'application/json'
        )]);

        $credentialsArr = array(
            "username" => "alice",
            "password" => "alice"
        );
        $response = $client->request('POST', '', [
            'json' => $credentialsArr
        ]);

        print_r($response->json());
    }

    public function knock()
    {

        // Create a client with a base URI
        $client = new GuzzleHttp\Client(['base_uri' => 'usdledger.online:1337', array(
            'content-type' => 'application/json'
        )]);


        $accountArr = array(
            "sender" => "https://usdledger.online/ledger/accounts/alice",
            "password" => "alice",
            "receiver" => "bob@eurledger.online",
            "amount" => number_format(10, 2, '.', ''),
            "message" => "hey sexy.i want you! :) xxxxx call me!"
        );

        // Send a request to https://foo.com/api/test
        $response = $client->request('POST', '/makeTransfer', [
            'json' => $accountArr
        ]);


        print_r(json_decode($response->getBody(), true));
    }


}