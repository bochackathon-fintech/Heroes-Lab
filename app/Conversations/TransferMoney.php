<?php
/**
 * Created by PhpStorm.
 * User: DarkP
 * Date: 6/10/2017
 * Time: 12:51 PM
 */

namespace app\Conversations;


class TransferMoney
{
    public static function checkbalance($balance, $available_balance) {

        return array("status" => true, "message" => "");
    }

    public static function checkinterledger($address) {
        return array("status" => true, "message" => ""); 
    }

    public static function checkpassword($password) {
         return array("status" => true, "message" => "");
    }

    public static function createTransfer($balance, $interledger) {
        return array("status" => false, "message" => "eftasame kopelia")
    }

}