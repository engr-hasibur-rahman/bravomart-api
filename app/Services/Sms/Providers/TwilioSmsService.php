<?php

namespace App\Services\Sms\Providers;

use App\Services\Sms\SmsInterface;
use Twilio\Rest\Client;

class TwilioSmsService implements SmsInterface
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $this->client = new Client(config('sms.twilio.sid'), config('sms.twilio.token'));
        $this->from = config('sms.twilio.from');
    }

    public function send(string $to, string $message): bool
    {
        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);
            return true;
        } catch (\Exception $e) {
            logger()->error('Twilio SMS Error: ' . $e->getMessage());
            return false;
        }
    }
}
