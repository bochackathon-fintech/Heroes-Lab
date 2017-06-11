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


    protected static $unusedRates = [
        'TRY',
        'THB',
        'CAD',
        'CZK',
        'DKK',
        'KRW',
        'SGD',
        'ZAR',
        'NOK',
        'INR',
        'ILS',
        'PHP',
        'RON',
        'RUB',
        'BGN',
        'HKD',
        'MXN',
        'IDR',
        'BRL'
    ];

    public static function run(string $currency)
    {

        return self::getRates($currency);
    }

    /**
     * Collect the rates form the JSON api
     * @param $base
     * @return mixed
     */
    public static function getRates($base)
    {
        $ratesJsonData = file_get_contents('http://api.fixer.io/latest?base=' . $base, true);
        if (!$ratesJsonData) {
            return 'Sorry I don`t know this rate base. Try EUR, USD, CHF...';
        }
        $ratesData = json_decode($ratesJsonData);
        $rates = self::removeUnusedRates((array)$ratesData->rates);
        return self::formatRates($ratesData->base, $ratesData->date, $rates);
    }

    /**
     * Format the rates for the message
     * @param $ratesBase
     * @param $ratesDate
     * @param $rates
     * @return string
     */
    private static function formatRates(string $ratesBase, string $ratesDate, array $rates)
    {
        $returnMessage = '💰 Your rates based on ' . $ratesBase . ':\r\n' . 'Date: ' . $ratesDate . '\r\n';
        foreach ($rates as $key => $rate) {
            $returnMessage .= $key . ' ' . $rate . '\n\r';
        }
        return $returnMessage;
    }

    /**
     * Remove some unused rates
     * @param array $rates
     * @return array
     */
    private static function removeUnusedRates(array $rates)
    {
        return array_filter($rates, function ($key) {
            return !in_array($key, self::$unusedRates);
        }, ARRAY_FILTER_USE_KEY);
    }

}