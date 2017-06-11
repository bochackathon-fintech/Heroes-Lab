<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Route::match(['get', 'post'], '/botman', 'BotManController@handle');

Route::get('webhook', 'AuthorizationController@verify');

Route::any('getuser','BotManController@getUser');
Route::any('knock', 'BotManController@knock');
Route::any('getCookie', 'BotManController@getCookie');

Route::any('checkinterledger', 'BotManController@checkinterledger');

Route::any('createuser','BotManController@createUser');
Route::any('makepayment','BotManController@createTransfer');

Route::get('test', function () {
    $api = new \App\Helpers\APIHelper(env('BOC_AUTH_PROVIDER_NAME', BOC_AUTH_PROVIDER_NAME), env('BOC_AUTH_ID', BOC_AUTH_ID), env('BOC_TOKEN', BOC_TOKEN));
    $info = $api->getAccountIDAndBankIDFromIBAN('GR8012345678901238126985255');
    $accountID = $info['id'];
    $swift = $info['bank_id'];
    $views = $api->getViews($swift);
    $views = array_get($views, 'views');
    $views = array_first($views);
    $viewID = $views['id'];
    $account = $api->getAccount($swift, $accountID, $viewID);
    $balance = array_get($account, 'balance.amount', 'Unknown');
    $currency = array_get($account, 'balance.currency', 'Unknown');
    $balanceText = $balance . ' ' . $currency;
    return $balanceText;
    //return $api->getAccountIDAndBankIDFromIBAN('GR8012345678901238126985255');
});