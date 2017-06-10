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
        $question = Question::create("Hello :).How can i help you ?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                //Button::create('Manage my Account')->value('account'),
                Button::create('Transfer Money')->value('transfer'),
                Button::create('Check currency rates')->value('rates'),
                // Button::create('Tell a joke')->value('joke'),
                // Button::create('Give me a fancy quote')->value('quote'),
            ]);
        return $this->ask($question, function (Answer $answer) use ($question) {
            logger(var_export($answer, true));
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
                        $available_balance = 100.00;
                        $interledger = "";
                        $balance = "";
                        $checkbalance = "";
                        $this->ask('Your available balance is ' . $available_balance . '. How much you would like to transfer?', function (Answer $answer) use ($interledger, $balance, $available_balance, $question) {
                            $checkbalance = TransferMoney::checkBalance($answer->getText(), $available_balance);
                            if (!$checkbalance['status']) {
                                $this->say($checkbalance['message']);
                                $this->repeat($question);
                            }
                            $balance = $answer->getText();

                            $this->reply(Buttontemplate::create("What's the occasion?")
                                ->addButton(ElementButton::create('Food')->value('Food'))
                            );
                            $occasion = Question::create("What's the occasion?")
                                    ->fallback('Unable to ask question')
                                    ->callbackId('transaction_answer')
                                    ->addButton(ElementButton::create('Food')->value('Food'))
                                    ->addButton(ElementButton::create('Other')->value('Other'));
                           $this->ask($summary, function (Answer $answer) use ($question, $balance, $interledger) {
                               if ($answer->isInteractiveMessageReply()) {
                                    $addCategory = TransferMoney::createCategory($answer->getValue());
                                    if (!$addCategory['status']) {
                                        $this->say($addCategory['message']);
                                        $this->repeat($question);
                                    }
                                $this->ask("Great, What's the private metis ID?", function (Answer $answer) use ($interledger, $checkbalance, $question, $balance) {
                                    $checkinterledger = TransferMoney::checkInterledger($answer->getText());
                                    if (!$checkinterledger['status']) {
                                        $this->say($checkbalance['message']);
                                        $this->repeat($question);
                                    }
                                    $interledger = $answer->getText();
                                    $currency = "&euro;";
                                    $summary = Question::create("In order to confirm you will like to send " .$currency. $balance . " to " . $interledger)
                                        ->fallback('Unable to ask question')
                                        ->callbackId('transaction_answer')
                                        ->addButtons([
                                            Button::create('Yes')->value('Y'),
                                            Button::create('No')->value('N')
                                        ]);
                                    $this->ask($summary, function (Answer $answer) use ($question, $balance, $interledger) {
                                        if ($answer->isInteractiveMessageReply()) {
                                            if ($answer->getValue() == 'Y') {
                                                $createTransfer = TransferMoney::createTransfer($balance, $interledger);
                                                if (!$createTransfer['status']) {
                                                    $this->say($createTransfer['message']);
                                                    $this->repeat($question);
                                                }
                                                $this->say("Your payment transfer was successful");
                                            } else {
                                                $this->repeat($question);
                                            }
                                        }

                                    });
                                });
                               }
                               else {
                                    $this->repeat($question);
                               }
                           });
                        });
                        break;
                    case "account":
                        $this->ask('What do you want?', function (Answer $answer) {
                            $answer->
                            $this->say(BOCApi::run($answer->getText()));
                        });
                        break;
                    default:
                        $this->say('Sorry i didnt get that.Try again!');
                        break;
                }
        });
    }


    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}