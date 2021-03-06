<?php

namespace App\Custom;


use Mpociot\BotMan\Interfaces\DriverInterface;
use Mpociot\BotMan\Interfaces\MiddlewareInterface;
use Mpociot\BotMan\Message;

class EnrichMessage implements MiddlewareInterface
{

    /**
     * Handle / modify the message.
     *
     * @param Message $message
     * @param DriverInterface $driver
     */
    public function handle(Message &$message, DriverInterface $driver)
    {
        if (!$driver->isBot()) {
            $message->addExtras('info', [
                'user' => $driver->getUser($message),
                'channel' => $message->getChannel()
            ]);
        }

    }

    /**
     * @param Message $message
     * @param string $test
     * @param bool $regexMatched Indicator if the regular expression was matched too
     * @return bool
     */
    public function isMessageMatching(Message $message, $test, $regexMatched)
    {
        return true;
    }
}