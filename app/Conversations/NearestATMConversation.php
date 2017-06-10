<?php

namespace App\Conversations;


use Mpociot\BotMan\Conversation;

class NearestATMConversation extends Conversation
{

    public function askLocation()
    {

    }

    /**
     * @return mixed
     */
    public function run()
    {
        $this->askLocation();
    }
}