<?php

namespace francoisvaillant\Sendsms;

use Mailjet\Client;
use Mailjet\Resources;


class SmsSender
{

    private string $token;
    private Client $client;

    public function __construct()
    {
    }

    public function connect(): self
    {
        if(!$this->token) {
            return $this;
        }
        $this->client = new Client($this->token, NULL, true, ['version' => 'v4']);
        return $this;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function send(SmsMessage $message): ?bool
    {
        if(!$message->hasError()) {
            $response = $this->client->post(Resources::$SmsSend, ['body' => $message->getMessage()]);
            return $response->success();
        }
        return false;
    }

}