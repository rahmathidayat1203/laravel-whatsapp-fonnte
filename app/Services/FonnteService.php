<?php

namespace App\Services;

use GuzzleHttp\Client;

class FonnteService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('FONNTE_API_KEY');
    }

    public function sendMessage($to, $message)
    {
        $response = $this->client->post('https://api.fonnte.com/send', [
            'headers' => [
                'Authorization' => $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'target' => $to,
                'message' => $message,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
