<?php

namespace App\Conversations;


use Mpociot\BotMan\Conversation;
use Treffynnon\Navigator;

class NearestATMConversation extends Conversation
{

    public function askLocation()
    {

        $distance = Navigator::getDistance($lat1, $long1, $lat2, $long2);

    }

    /**
     * @return mixed
     */
    public function run()
    {
        $this->askLocation();
    }
}