<?php

namespace App\Http\Controllers;

use App\Conversations\FirstTimeConversation;
use App\Conversations\StartConversation;
use App\Custom\EnrichMessage;
use App\User;
use GuzzleHttp;
use Mpociot\BotMan\Answer;
use Mpociot\BotMan\BotMan;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Question;

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
        $botman->hears('How are you', function (BotMan $bot) {

            $bot->reply('I am fine thanks.You? :)');
        });
        $botman->hears('Whats your name?', function (BotMan $bot) {

            $bot->reply('My name is Metis.Nice to meet you!');
        });

        $botman->hears('start|begin|help|commands', function (BotMan $bot) {
            $bot->startConversation(new StartConversation());
        })->middleware(new EnrichMessage());

        //user clicked get started button the first time
        $botman->hears(config('services.botman.facebook_start_button_payload'), function (BotMan $bot) {
            $bot->startConversation(new FirstTimeConversation($bot, $bot->getMessage()->getChannel()));
        })->middleware(new EnrichMessage());

        //ask user to give information
        if (User::where('user_id', $botman->getUser()->getId())->count() === 0) {
            $question = Question::create('I haven`t met you yet.Would you like to give me some information?')
                ->fallback('I didn`t catch that')
                ->addButtons([
                    Button::create('Yes')->value('yes'),
                    Button::create('No')->value('no'),
                ]);
            $botman->ask($question, function (Answer $answer) use ($botman) {
                if ($answer->getValue() === 'yes') {
                    $botman->startConversation(new FirstTimeConversation($botman, $botman->getMessage()->getChannel()));
                } else {
                    $botman->say('Sorry to hear that :(', $botman->getMessage()->getChannel());
                }
            });
        } else {
            //login user automatically
            \Auth::login(User::where('user_id', $botman->getUser()->getId())->first());
        }


        //list to user
        $botman->listen();
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */

    public
    function startConversation(BotMan $bot)
    {
        $bot->startConversation(new StartConversation());
    }


    public
    function getCookie()
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://usdledger.online/api/auth/login', array(
            'content-type' => 'application/json',
        )]);

        $credentialsArr = array(
            "username" => "alice",
            "password" => "alice"
        );


        $response = $client->request('POST', '', [
            'json' => $credentialsArr
        ]);


        echo $response->getBody();
        // var_dump($response->getHeader('Set-Cookie'));

        // print_r(json_decode($response->getHeader('Set-Cookie'), true));
    }

    public
    function knock()
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

    public
    function createUser()
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://usdledger.online/ledger/users/kostis', array(
            'content-type' => 'application/json',
        )]);

        $createUser = array(
            "password" => "kostis"
        );


        $response = $client->request('POST', '', [
            'json' => $createUser
        ]);


        echo $response->getBody();
    }
    
    public function getUser() {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://usdledger.online/ledger/accounts/alice', array(
            'content-type' => 'application/json'
        )]);
        $response = $client->request('GET', '/makeTransfer', [

        ]);
        print_r($response->getBody());
    }

}