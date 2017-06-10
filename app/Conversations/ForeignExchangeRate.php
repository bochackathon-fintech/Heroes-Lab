<?php
/**
 * Created by PhpStorm.
 * User: DarkP
 * Date: 6/10/2017
 * Time: 12:25 PM
 */

namespace app\Conversations;


class ForeignExchangeRate
{

    /**
     * @param \BotMan $botMan
     * @return mixed
     */
    public static function run(string $currency)
    {

        return 'You choose ' . $currency;
    }
}