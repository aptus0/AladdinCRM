<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Version Update Check
    |--------------------------------------------------------------------------
    |
    | Optional endpoint that returns JSON with at least "latest_version".
    | Example response:
    | { "latest_version": "1.1.0", "download_url": "...", "notes_url": "..." }
    |
    */
    'check_url' => env('APP_VERSION_CHECK_URL'),
    'cache_minutes' => (int) env('APP_VERSION_CACHE_MINUTES', 30),
    'timeout_seconds' => (int) env('APP_VERSION_TIMEOUT_SECONDS', 3),
];

