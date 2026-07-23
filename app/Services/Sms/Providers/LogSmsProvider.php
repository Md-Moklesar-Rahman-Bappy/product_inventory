<?php

namespace App\Services\Sms\Providers;

use Illuminate\Support\Facades\Log;

class LogSmsProvider implements SmsProviderInterface
{
    public function send(string $phone, string $message): bool
    {
        Log::info('SMS sent (log driver)', [
            'phone' => $phone,
            'message' => $message,
        ]);

        return true;
    }
}
