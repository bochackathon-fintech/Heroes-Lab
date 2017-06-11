<?php
/**
 * Created by PhpStorm.
 * User: DarkP
 * Date: 6/10/2017
 * Time: 12:51 PM
 */

namespace App\Conversations;


class TransferMoneyConversation
{
    public static function checkbalance($balance, $available_balance) {
        if($balance )
        if (is_numeric($balance)) {
            if($balance <= $available_balance)
                 return array("status" => true, "message" => "");
            else
                return array("status" => false, "message" => "Shame, it looks that your balance dont have sufficient amount to send. :(");
        } else 
            return array("status" => true, "message" => "The amount that you provide is not number");

        return array("status" => true, "message" => "");
    }

    public static function checkinterledger($address) {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://usdledger.online/api/users', array(
            'content-type' => 'application/json',
            'Authorization' => "YWxpY2U6YWxpY2U="
            
        )]);
        
        $response = $client->request('GET', '/', [
        ]);
        
        foreach($response->getBody() as $interledger) {
            if($address == $interledger['identifier']) {
                return array("status" => true, "message" => ""); 
            }
        }            
        return array("status" => false, "message" => "Metis ID not found"); 
    }


    public static function createTransfer($balance, $interledger) {
        // Create a client with a base URI
        $client = new GuzzleHttp\Client(['base_uri' => 'usdledger.online:1337', array(
            'content-type' => 'application/json'
        )]);


        $accountArr = array(
            "sender" => "https://usdledger.online/ledger/accounts/alice",
            "password" => "alice",
            "receiver" => $interledger,
            "amount" => $balance,
            "message" => "payment transfer"
        );

        // Send a request to https://foo.com/api/test
        $response = $client->request('POST', '/makeTransfer', [
            'json' => $accountArr
        ]);
        return array("status" => true, "message" => "");
    }

}