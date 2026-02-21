<?php

return [
    /*
    |--------------------------------------------------------------------------
    | License Verification
    |--------------------------------------------------------------------------
    |
    | If enabled, the application can ping a central licensing service and
    | validate the configured key. "enforce" blocks requests when invalid.
    | Keep enforce disabled until your license service is ready in production.
    |
    */
    'enabled' => (bool) env('LICENSE_CHECK_ENABLED', false),
    'enforce' => (bool) env('LICENSE_ENFORCE', false),
    'key' => env('ALLADDIN_LICENSE_KEY'),
    'verify_url' => env('LICENSE_VERIFY_URL'),
    'cache_minutes' => (int) env('LICENSE_CACHE_MINUTES', 10),
    'timeout_seconds' => (int) env('LICENSE_TIMEOUT_SECONDS', 3),
];

