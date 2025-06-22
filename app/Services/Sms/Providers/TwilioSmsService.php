<?php

namespace App\Services\Sms\Providers;

use App\Services\Sms\SmsInterface;
use Twilio\Rest\Client;

class TwilioSmsService implements SmsInterface
{
    protected Client $client;
    protected string $from;

    public function __construct(array $credentials)
    {
        $this->client = new Client($credentials['twilio_sid'], $credentials['twilio_auth_key']);
        $this->from = $credentials['from'] ?? 'AppName';
    }

    public function send(string $to, string $message): bool
    {
        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);
            return true;
        } catch (\Throwable $e) {
            logger()->error('Twilio SMS Error: ' . $e->getMessage());
            return false;
        }
    }
}
