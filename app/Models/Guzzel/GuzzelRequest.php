<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 2/13/18
 * Time: 2:34 AM
 */

namespace App\Models\Guzzel;

use GuzzleHttp;

class GuzzelRequest
{
    private $client;
    private $accessToken = null;

    function __construct()
    {
        $this->client = new GuzzleHttp\Client();
        return $this;
    }

    public function getToken($email, $password){
        $url = url('/').'/api/login';
        $response =  $this->client->post($url, [
            'form_params' => [
                'email' => $email,
                'password' => $password
            ]
        ]);
        $resultJSON = json_decode((string) $response->getBody(), true);
        $this->accessToken = $resultJSON['success']['token'];
        return $this->accessToken;
    }

    public function manipulator($accessToken, $filters){
        $url = url('/').'/api/manipulator';

        $response = $this->client->post($url, [
            'headers' => [
                'Accept' => 'application/xml',
                'Authorization' => 'Bearer '.$accessToken,
            ],
            'form_params' => $filters
        ]);

        return (string) $response->getBody();
    }




}