<?php

namespace App\Services\Sms;



use App\Services\Sms\Providers\TwilioSmsService;
use App\Services\Sms\Providers\NexmoSmsService;
use Modules\SmsGateway\app\Models\SmsProvider;

class SmsManager
{
    public static function driver(): SmsInterface
    {
        $provider = SmsProvider::where('status', 1)->first();

        if (!$provider) {
            throw new \Exception('No active SMS provider found.');
        }

        $credentials = json_decode($provider->credentials, true);

        return match ($provider->slug) {
            'nexmo' => new NexmoSmsService($credentials),
            'twilio' => new TwilioSmsService($credentials),
            default => throw new \Exception('Unsupported SMS provider: ' . $provider->slug),
        };
    }

    public static function send(string $to, string $message): bool
    {
        return self::driver()->send($to, $message);
    }
}