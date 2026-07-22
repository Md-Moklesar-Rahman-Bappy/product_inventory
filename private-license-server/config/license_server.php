<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Signing Secret
    |--------------------------------------------------------------------------
    |
    | A secret key used to sign API responses. This is only available on the
    | private license server. The client application stores the encrypted
    | signed responses but cannot generate valid signatures.
    |
    */

    'signing_secret' => env('LICENSE_SIGNING_SECRET', 'CHANGE-THIS-TO-A-STRONG-SECRET-KEY-IN-PRODUCTION'),

    /*
    |--------------------------------------------------------------------------
    | Default License Duration
    |--------------------------------------------------------------------------
    |
    | The default number of days a license is valid when created without an
    | explicit expiration date. Set to null for no expiration.
    |
    */

    'default_duration_days' => (int) env('LICENSE_DEFAULT_DURATION_DAYS', 365),

    /*
    |--------------------------------------------------------------------------
    | Allowed IP Addresses for API
    |--------------------------------------------------------------------------
    |
    | If set, only requests from these IP addresses will be allowed to call
    | the license API endpoints. Leave empty to allow all IPs.
    |
    */

    'allowed_ips' => array_filter(explode(',', env('LICENSE_ALLOWED_API_IPS', ''))),

];
