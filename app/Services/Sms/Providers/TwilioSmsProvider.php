<?php

namespace App\Services\Sms\Providers;

use Twilio\Rest\Client;

class TwilioSmsProvider implements SmsProviderInterface
{
    public function send(string $phone, string $message): bool
    {
        $sid = config('sms.providers.twilio.account_sid');
        $token = config('sms.providers.twilio.auth_token');
        $from = config('sms.providers.twilio.from_number');

        if (!$sid || !$token || !$from) {
            return false;
        }

        $client = new Client($sid, $token);
        $client->messages->create($phone, [
            'from' => $from,
            'body' => $message,
        ]);

        return true;
    }
}
