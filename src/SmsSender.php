<?php

namespace francoisvaillant\Sendsms;

use Mailjet\Client;
use Mailjet\Resources;


class SmsSender
{

    /**
     * @var string
     */
    private string $token;

    /**
     * @var Client
     */
    private Client $client;


    public function __construct()
    {
    }

    /**
     * @return $this
     * creates connection with mailjet SMS API
     */
    public function connect(): self
    {
        if(!$this->token) {
            return $this;
        }
        $this->client = new Client($this->token, NULL, true, ['version' => 'v4']);
        return $this;
    }

    /**
     * @param string $token
     * @return $this
     * Set mailjet api key to mailjet Client
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param SmsMessage $message
     * @return bool|null
     * Senbd SMS Message
     */
    public function send(SmsMessage $message): ?bool
    {
        if(!$message->hasError()) {
            $response = $this->client->post(Resources::$SmsSend, ['body' => $message->getMessage()]);
            return $response->success();
        }
        return false;
    }

}