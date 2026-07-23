<?php

namespace App\Services\Sms;

use App\Services\Sms\Providers\SmsProviderInterface;

class SmsService
{
    protected SmsProviderInterface $provider;

    public function __construct()
    {
        $driverName = config('sms.default', 'log');
        $providerClass = config("sms.providers.{$driverName}.driver");

        $this->provider = app($providerClass);
    }

    public function send(string $phone, string $message): bool
    {
        return $this->provider->send($phone, $message);
    }

    public function sendOtp(string $phone, string $otp): bool
    {
        $appName = config('app.name', 'Application');
        $expiryMinutes = config('sms.otp_expiry_minutes', 5);

        $message = "Your {$appName} password reset code is: {$otp}. Valid for {$expiryMinutes} minutes. Do not share this code.";

        return $this->send($phone, $message);
    }

    public function generateOtp(): string
    {
        $length = config('sms.otp_length', 6);
        $max = (int) str_repeat('9', $length);
        $min = (int) str_repeat('0', $length - 1) . '1';

        return str_pad((string) random_int($min, $max), $length, '0', STR_PAD_LEFT);
    }
}
