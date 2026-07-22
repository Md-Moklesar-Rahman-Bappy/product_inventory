<?php

return [

    /*
    |--------------------------------------------------------------------------
    | License Server URL
    |--------------------------------------------------------------------------
    |
    | The base URL of your private license server. The client application
    | will communicate with this server to activate and verify licenses.
    | This must be an HTTPS URL in production.
    |
    */

    'license_server_url' => env('LICENSE_SERVER_URL', 'https://license.example.com'),

    /*
    |--------------------------------------------------------------------------
    | Product ID
    |--------------------------------------------------------------------------
    |
    | A unique identifier for this product on the license server.
    | This is configured on both the client and server side.
    |
    */

    'product_id' => env('LICENSE_PRODUCT_ID', 'product_inventory_v1'),

    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | The current version of the application. This is sent to the license
    | server during activation and verification checks.
    |
    */

    'app_version' => env('LICENSE_APP_VERSION', '1.0.0'),

    /*
    |--------------------------------------------------------------------------
    | License Check Interval (Days)
    |--------------------------------------------------------------------------
    |
    | How often the application should contact the remote license server
    | to verify the license is still valid. The application will use the
    | local cache between checks.
    |
    */

    'check_interval_days' => (int) env('LICENSE_CHECK_INTERVAL_DAYS', 7),

    /*
    |--------------------------------------------------------------------------
    | Offline Grace Period (Days)
    |--------------------------------------------------------------------------
    |
    | If the license server is unreachable, the application will continue
    | working for this many days after the last successful check. After
    | this period, access will be blocked.
    |
    */

    'offline_grace_days' => (int) env('LICENSE_OFFLINE_GRACE_DAYS', 7),

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    |
    | The API endpoint paths relative to the license server URL.
    |
    */

    'activation_endpoint' => '/api/license/activate',
    'check_endpoint' => '/api/license/check',

    /*
    |--------------------------------------------------------------------------
    | License Cache Path
    |--------------------------------------------------------------------------
    |
    | The path (relative to storage/app) where the encrypted license
    | cache file is stored. This file contains the encrypted license
    | data and should not be publicly accessible.
    |
    */

    'cache_path' => 'license.json',

    /*
    |--------------------------------------------------------------------------
    | Installation Lock Path
    |--------------------------------------------------------------------------
    |
    | The path (relative to storage/app) where the installation lock
    | file is stored. This file prevents re-installation.
    |
    */

    'installed_path' => 'installed',

    /*
    |--------------------------------------------------------------------------
    | Request Timeout (Seconds)
    |--------------------------------------------------------------------------
    |
    | Maximum time in seconds to wait for a response from the license
    | server during activation or verification checks.
    |
    */

    'request_timeout' => (int) env('LICENSE_REQUEST_TIMEOUT', 10),

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | A shared secret key sent with every API request to the license server.
    | This must match the LICENSE_API_KEY on the license dashboard.
    |
    */

    'api_key' => env('LICENSE_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Signature Verification
    |--------------------------------------------------------------------------
    |
    | The server signs active responses with HMAC SHA256 using its private
    | LICENSE_SIGNING_SECRET. The client stores this signature for audit
    | purposes but does NOT verify it — the signing secret never leaves
    | the server. Client-side tamper detection uses APP_KEY instead.
    |
    */

];
