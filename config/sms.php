<?php

return [

    'default' => env('SMS_PROVIDER', 'log'),

    'providers' => [

        'log' => [
            'driver' => \App\Services\Sms\Providers\LogSmsProvider::class,
        ],

        'twilio' => [
            'driver' => \App\Services\Sms\Providers\TwilioSmsProvider::class,
            'account_sid' => env('TWILIO_SID'),
            'auth_token' => env('TWILIO_TOKEN'),
            'from_number' => env('TWILIO_FROM'),
        ],

    ],

    'otp_length' => 6,

    'otp_expiry_minutes' => 5,

    'max_attempts' => 5,

];
