<?php

namespace App\Conversations;

use App\Mail\VerifiedTransaction;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Inspiring;
use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Conversation;
use Mpociot\BotMan\Facebook\ElementButton;
use Mpociot\BotMan\Question;

use Transaction;
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
            if ($answer->isInteractiveMessageReply()) {
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
                        $api = new \App\Helpers\APIHelper(env('BOC_AUTH_PROVIDER_NAME'), env('BOC_AUTH_ID'), env('BOC_TOKEN'));

                        $results = $api->getAccount();
                        $available_balance = $results['balance']['amount'];
                        $currency = $results['balance']['currency'];
                        
                        $this->ask('Your available balance is '.$currency.$available_balance . '. How much you would like to transfer?', function (Answer $answer) use ($available_balance, $currency, $question) {
                            $checkbalance = TransferMoneyConversation::checkBalance($answer->getText(), $available_balance);
                            if (!$checkbalance['status']) {
                                $this->say($checkbalance['message']);
                                $this->repeat($question);
                            }
                            $amount = $answer->getText();

                            $occasion = Question::create("What's the occasion?")
                                    ->fallback('Unable to ask question')
                                    ->callbackId('transaction_answer')
                                    ->addButton(ElementButton::create('Food')->value('Food'))
                                    ->addButton(ElementButton::create('Other')->value('Other'));
                            $this->ask($occasion, function (Answer $answer) use ($question, $amount, $available_balance, $currency) {
                               if ($answer->isInteractiveMessageReply()) {
                                    $category = $answer->getValue();
                                    $this->ask("Great, What's the private metis ID?", function (Answer $answer) use ($question, $amount, $available_balance ,$category, $currency) {
                                        $checkinterledger = TransferMoneyConversation::checkInterledger($answer->getText());
                                        if (!$checkinterledger['status']) {
                                            $this->say($checkinterledger['message']);
                                            $this->repeat($question);
                                        }
                                        $user_interledger = $answer->getText();

                                        $summary = Question::create("In order to confirm you will like to send " .$amount ." ".$currency." to " . $user_interledger)
                                            ->fallback('Unable to ask question')
                                            ->callbackId('transaction_answer')
                                            ->addButtons([
                                                Button::create('Yes')->value('Y'),
                                            ]);
                                        $this->ask($summary, function (Answer $answer) use ($question, $available_balance ,$amount, $category, $user_interledger) {
                                            if ($answer->isInteractiveMessageReply()) {
                                                if ($answer->getValue() == 'Y') {
                                                    $this->ask("", function(Answer $answer)  use ($question, $available_balance, $amount, $category ,$user_interledger) {

                                                        $verification_number = rand(pow(10, 4-1), pow(10, 4)-1);

                                                        Mail::to("lambrianidesg@gmail.com")->send(new VerifiedTransaction($verification_number));

                                                        if($verification_number != $answer->getText()) {
                                                            $this->say("Ohh damn, it seems that your verification code is wrong :(");
                                                            $this->repeat($question);
                                                        }
                                                        else {
                                                            $createTransfer = TransferMoneyConversation::createTransfer($amount, $user_interledger );
                                                            if (!$createTransfer['status']) {
                                                                $this->say($createTransfer['message']);
                                                                $this->repeat($question);
                                                            }
                                                            $transaction = new Transaction();
                                                            $transaction->user_id = Auth::User()->id;
                                                            $transaction->status = 'C';
                                                            $transaction->verification_number = $verification_number;
                                                            $transaction->amount = $amount;
                                                            $transaction->balance = $available_balance;
                                                            $transaction->category = $category;
                                                            $transaction->interledger_user = $user_interledger;
                                                            $transaction->bank_account_id = "1234653535325363";
                                                            $transaction->save();
                                                            $this->say("Your payment transfer was successful");
                                                        }
                                                    });    
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