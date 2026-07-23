<?php

namespace App\Services\Sms\Providers;

interface SmsProviderInterface
{
    public function send(string $phone, string $message): bool;
}
