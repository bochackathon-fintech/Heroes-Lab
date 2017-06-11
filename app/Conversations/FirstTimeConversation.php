<?php

namespace App\Conversations;


use App\Helpers\APIHelper;
use App\User;
use App\UserBankAccount;
use Exception;
use Log;
use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Conversation;
use Mpociot\BotMan\Question;


class FirstTimeConversation extends Conversation
{

    public function askForBankAccountDetails(User $user)
    {
        $bankAccount = new UserBankAccount();
        //TODO INTEGRATION WHEN AVAILABLE
        $bankAccount->auth_provider_name = env('BOC_AUTH_PROVIDER_NAME');
        $bankAccount->auth_id = env('BOC_AUTH_ID');
        $bankAccount->auth_token_key = env('BOC_TOKEN');

        $this->say('We are close to the end.One last question...');
        $question = Question::create('What is your IBAN number?');
        $this->ask($question, function (Answer $answer) use ($bankAccount, $question, $user) {
            $bankAccount->iban = $answer->getText();
            //get account
            $api = new APIHelper(env('BOC_AUTH_PROVIDER_NAME'), env('BOC_AUTH_ID'), env('BOC_TOKEN'));
            try {
                //GR8012345678901238126985255
                $info = $api->getAccountIDAndBankIDFromIBAN($answer->getText());
                $bankAccount->swift = $info['bank_id'];
                $bankAccount->account_id = $info['id'];
                $bankAccount->user_id = $user->id;

            } catch (Exception $exception) {
                Log::error($exception);
                $this->say('Sorry your IBAN number is incorrect.Try again');
                $this->repeat($question);
            }

        });

        //get balance
        //$balance = $api->getViews();

        //save bank account and associate with user
        if ($user->username == null) {
            $user->username = $user->email;
        }
        $user->save();
        $bankAccount->save();
        $user->bankAccounts()->save($bankAccount);

        $this->say('That`s it! Thank you :).You are now connected with your Financial Account');

    }

    public function askForPassword(User $user)
    {
        $this->say('For security reasons we need to set a strong password for password recovery and locking your account');
        $this->ask('What is your password?', function (Answer $answer) use ($user) {
            $user->password = encrypt($answer->getText());
            $this->askForBankAccountDetails($user);

        });

    }

    public function askForEmail(User $user)
    {
        $this->say('For security reasons we need your email');
        $this->ask('What is your email?', function (Answer $answer) use ($user) {
            $email = $answer->getText();
            $user->email = $email;
            $this->bot->userStorage()->save(['email' => $email]);
            $this->askForPassword($user);

        });

    }

    public function askForName(User $user)
    {

        $question = Question::create('Is that correct?')
            ->fallback('I didn`t catch that')
            ->addButtons([
                Button::create('Yes')->value('yes'),
                Button::create('No')->value('no'),
            ]);

        $this->ask($question, function (Answer $answer) use ($user) {
            if ($answer->getValue() === 'yes') {
                $this->bot->userStorage()->save(['name' => $this->bot->getUser()->getFirstName(), 'surname' => $this->bot->getUser()->getLastName()]);
                $user->user_id = $this->bot->getUser()->getId();
                $user->channel_id = $this->bot->getMessage()->getConversationIdentifier();
                $user->username = $this->bot->getUser()->getUsername();
                $user->name = $this->bot->getUser()->getFirstName();
                $user->surname = $this->bot->getUser()->getLastName();
            } else {
                $user->user_id = $this->bot->getUser()->getId();
                $user->username = $this->bot->getUser()->getUsername();
                $user->channel_id = $this->bot->getMessage()->getConversationIdentifier();

                $this->ask('What is your first name?', function (Answer $answer) use ($user) {
                    $user->name = $answer->getText();
                    $this->ask('What is your last name?', function (Answer $answer) use ($user) {
                        $user->surname = $answer->getText();
                    });
                });

            }
            $this->askForEmail($user);

        });


    }

    /**
     * First question
     */
    public function firstTime()
    {
        $bot = $this->bot;
        $user = $this->bot->getUser();
        $this->say('Hello there:) Welcome to Metis.I can help you with your Financial Account but first i need some information from you.');
        $this->say('Your name is ' . $user->getFirstName() . ' ' . $user->getLastName());
        $this->askForName(new User());

        // $question = Question::create("Hello :).How can i help you ?")
        //     ->fallback('Unable to ask question')
        //     ->callbackId('ask_reason')
        //     ->addButtons([
        //         //Button::create('Manage my Account')->value('account'),
        //         Button::create('Transfer Money')->value('transfer'),
        //         Button::create('Check currency rates')->value('rates'),
        //         // Button::create('Tell a joke')->value('joke'),
        //         // Button::create('Give me a fancy quote')->value('quote'),
        //     ]);
        // return $this->ask($question, function (Answer $answer) use ($question) {
        //     logger(var_export($answer, true));
        //     if ($answer->isInteractiveMessageReply())
        //         switch ($answer->getValue()) {
        //             case "joke":
        //                 $joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
        //                 $this->say($joke->value->joke);
        //                 break;
        //             case "quote":
        //                 $this->say(Inspiring::quote());
        //                 break;
        //             case "rates":
        //                 $this->ask('Whats your currency?', function (Answer $answer) {
        //                     $this->say(ForeignExchangeRate::run($answer->getText()));
        //                 });
        //                 break;
        //             case "transfer":
        //                 $available_balance = 100.00;
        //                 $interledger = "";
        //                 $balance = "";
        //                 $checkbalance = "";
        //                 $this->ask('Your available balance is ' . $available_balance . '. How much you would like to transfer?', function (Answer $answer) use ($interledger, $balance, $available_balance, $question) {
        //                     $checkbalance = TransferMoney::checkBalance($answer->getText(), $available_balance);
        //                     if (!$checkbalance['status']) {
        //                         $this->say($checkbalance['message']);
        //                         $this->repeat($question);
        //                     }
        //                     $balance = $answer->getText();

        //                     $this->ask("Great, What's the private metis ID?", function (Answer $answer) use ($interledger, $checkbalance, $question, $balance) {
        //                         $checkinterledger = TransferMoney::checkInterledger($answer->getText());
        //                         if (!$checkinterledger['status']) {
        //                             $this->say($checkbalance['message']);
        //                             $this->repeat($question);
        //                         }
        //                         $interledger = $answer->getText();
        //                         $currency = "&euro;";
        //                         $summary = Question::create("In order to confirm you will like to send " .$currency. $balance . " to " . $interledger)
        //                             ->fallback('Unable to ask question')
        //                             ->callbackId('transaction_answer')
        //                             ->addButtons([
        //                                 Button::create('Yes')->value('Y'),
        //                                 Button::create('No')->value('N')
        //                             ]);
        //                         $this->ask($summary, function (Answer $answer) use ($question, $balance, $interledger) {
        //                             if ($answer->isInteractiveMessageReply()) {
        //                                 if ($answer->getValue() == 'Y') {
        //                                     $createTransfer = TransferMoney::createTransfer($balance, $interledger);
        //                                     if (!$createTransfer['status']) {
        //                                         $this->say($createTransfer['message']);
        //                                         $this->repeat($question);
        //                                     }
        //                                     $this->say("Your payment transfer was successful");
        //                                 } else {
        //                                     $this->repeat($question);
        //                                 }
        //                             }

        //                         });
        //                     });
        //                 });
        //                 break;
        //             case "account":
        //                 $this->ask('What do you want?', function (Answer $answer) {
        //                     $answer->
        //                     $this->say(BOCApi::run($answer->getText()));
        //                 });
        //                 break;
        //             default:
        //                 $this->say('Sorry i didnt get that.Try again!');
        //                 break;
        //         }
        // });
    }


    /**
     * Start the conversation
     */
    public function run()
    {
        $this->firstTime();
    }
}