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

Route::get('test', function () {
    $api = new \App\Helpers\APIHelper(env('BOC_AUTH_PROVIDER_NAME'), env('BOC_AUTH_ID'), env('BOC_TOKEN'));
    //return $api->getAccountIDAndBankIDFromIBAN('GR8012345678901238126985255');
    return $api->getAccountIDAndBankIDFromIBAN('GR8012345678901238126985255');
});