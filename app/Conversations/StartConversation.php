<?php

namespace App\Conversations;


use Illuminate\Foundation\Inspiring;
use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Conversation;
use Mpociot\BotMan\Question;

class StartConversation extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create("Huh - you woke me up. What do you need?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                //Button::create('Manage my Account')->value('account'),
                // Button::create('Transfer Money')->value('transfer'),
                Button::create('Check currency rates')->value('rates'),
                // Button::create('Tell a joke')->value('joke'),
                // Button::create('Give me a fancy quote')->value('quote'),
            ]);
        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply())
                switch ($answer->getValue()) {
                    case "joke":
                        $joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                        $this->say($joke->value->joke);
                        break;
                    case "quote":
                        $this->say(Inspiring::quote());
                        break;
                    case "rates":
                        $this->ask('Whats your currency?', function (Answer $answer) {
                            $this->say(ForeignExchangeRate::run($answer->getText()));
                        });
                        break;
                    case "transfer":
                        $this->say();
                        break;
                    case "account":
                        $this->say();
                        break;
                    default:
                        $this->say('Sorry i didnt get that.Try again!');
                        break;
            }
        });
    }

    public function askRates()
    {

    }


    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}