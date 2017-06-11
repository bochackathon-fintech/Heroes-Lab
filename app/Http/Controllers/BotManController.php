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
        $botman->hears('How are you', function (BotMan $bot) {

            $bot->reply('I am fine thanks.You? :)');
        });
        $botman->hears('Whats your name?', function (BotMan $bot) {

            $bot->reply('My name is Metis.Nice to meet you!');
        });

        $botman->hears('begin|hi|hello', function (BotMan $bot) {
            $bot->startConversation(new StartConversation());
        })->middleware(new EnrichMessage());

        //user clicked get started button the first time
        $botman->hears(config('services.botman.facebook_start_button_payload'), function (BotMan $bot) {
            $bot->startConversation(new FirstTimeConversation($bot, $bot->getMessage()->getChannel()));
        })->middleware(new EnrichMessage());
        
        $botman->hears('DELETE_ACCOUNT', function (BotMan $bot) {
            $bot->ask("in order to delete your account, we would like you to type your password",function (Answer $answer) {
                if($answer->getText()) {
                    if (Hash::check($answer->getText(), Auth::User()->password)) {
                        $user =Auth::User();
                        $user->is_locked = true;
                        $user->save();
                        
                        $bot->reply('your account has been locked');
                    }
                    else
                        $bot->reply('Oh dear, Wrong password :( ');       
                }
            });
       
        })->middleware(new EnrichMessage());

        //ask user to give information
        if (User::where('user_id', $botman->getUser()->getId())->count() === 0) {
            $botman->channelStorage()->delete();
            $botman->driverStorage()->delete();
            $botman->userStorage()->delete();


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
}