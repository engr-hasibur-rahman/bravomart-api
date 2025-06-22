<?php

namespace App\Services\Sms\Providers;

use App\Services\Sms\SmsInterface;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;

class NexmoSmsService implements SmsInterface
{
    protected $client;
    protected $from;

    public function __construct(array $credentials)
    {
        $this->client = new Client(new Basic(
            $credentials['nexmo_api_key'],
            $credentials['nexmo_api_secret']
        ));
        $this->from = $credentials['from'] ?? 'AppName';
    }

    public function send(string $to, string $message): bool
    {
        try {
            $result = $this->client->message()->send([
                'to'   => $to,
                'from' => $this->from,
                'text' => $message,
            ]);

            return $result->getStatus() === 0;
        } catch (\Exception $e) {
            logger()->error("Nexmo SMS Error: " . $e->getMessage());
            return false;
        }
    }
}