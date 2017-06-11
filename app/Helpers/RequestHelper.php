<?php

namespace app\Helpers;


use GuzzleHttp\Client;

class RequestHelper
{

    public static function get(string $url, string $authProvider, string $authID, string $tokenKey)
    {
        $options = ['content-type' => 'application/json'];
        $headers = [
            'Auth-Provider-Name' => $authProvider,
            'Auth-ID' => $authID,
            'Ocp-Apim-Subscription-Key' => $tokenKey
        ];

        $client = new Client(['headers' => $headers]);
        $response = $client->request('GET', $url, $options);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception($response->getReasonPhrase(), $response->getStatusCode());
        }

        return json_decode($response->getBody(), true);
    }

    public static function post(string $url, string $authProvider, string $authID, string $tokenKey)
    {
        $options = ['content-type' => 'application/json'];
        $headers = [
            'Auth-Provider-Name' => $authProvider,
            'Auth-ID' => $authID,
            'Ocp-Apim-Subscription-Key' => $tokenKey
        ];

        $client = new Client(['headers' => $headers]);
        $response = $client->request('POST', $url, $options);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception($response->getReasonPhrase(), $response->getStatusCode());
        }

        return json_decode($response->getBody(), true);
    }

}