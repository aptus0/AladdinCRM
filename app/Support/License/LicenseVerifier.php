<?php

namespace App\Support\License;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class LicenseVerifier
{
    /**
     * @return array{
     *     enabled: bool,
     *     valid: bool,
     *     enforced: bool,
     *     source: string,
     *     message: string,
     *     key_last4: string|null,
     *     checked_at: string
     * }
     */
    public function verify(string $domain, string $appVersion): array
    {
        $enabled = (bool) config('license.enabled', false);
        $enforced = (bool) config('license.enforce', false);

        if (! $enabled) {
            return $this->status(
                enabled: false,
                valid: true,
                enforced: $enforced,
                source: 'disabled',
                message: 'License check disabled.',
                key: null,
            );
        }

        $licenseKey = trim((string) config('license.key', ''));
        $verifyUrl = trim((string) config('license.verify_url', ''));
        $cacheMinutes = max((int) config('license.cache_minutes', 10), 1);

        $cacheKey = sprintf(
            'license:status:%s',
            sha1($domain.'|'.$appVersion.'|'.$licenseKey.'|'.$verifyUrl),
        );

        return Cache::remember(
            $cacheKey,
            Carbon::now()->addMinutes($cacheMinutes),
            function () use ($enforced, $licenseKey, $verifyUrl, $domain, $appVersion): array {
                if ($licenseKey === '') {
                    return $this->status(
                        enabled: true,
                        valid: false,
                        enforced: $enforced,
                        source: 'config',
                        message: 'License key not configured.',
                        key: null,
                    );
                }

                if ($verifyUrl === '') {
                    return $this->status(
                        enabled: true,
                        valid: ! $enforced,
                        enforced: $enforced,
                        source: 'config',
                        message: 'License verify URL not configured.',
                        key: $licenseKey,
                    );
                }

                try {
                    $timeout = max((int) config('license.timeout_seconds', 3), 1);

                    $response = Http::timeout($timeout)
                        ->acceptJson()
                        ->post($verifyUrl, [
                            'license_key' => $licenseKey,
                            'domain' => $domain,
                            'app_name' => (string) config('app.name'),
                            'app_version' => $appVersion,
                        ]);

                    if (! $response->ok()) {
                        return $this->status(
                            enabled: true,
                            valid: ! $enforced,
                            enforced: $enforced,
                            source: 'remote',
                            message: sprintf('License server error (%d).', $response->status()),
                            key: $licenseKey,
                        );
                    }

                    $payload = (array) $response->json();
                    $isValid = (bool) ($payload['valid'] ?? false);
                    $message = (string) ($payload['message'] ?? ($isValid ? 'License is valid.' : 'License is invalid.'));

                    return $this->status(
                        enabled: true,
                        valid: $isValid,
                        enforced: $enforced,
                        source: 'remote',
                        message: $message,
                        key: $licenseKey,
                    );
                } catch (Throwable $exception) {
                    return $this->status(
                        enabled: true,
                        valid: ! $enforced,
                        enforced: $enforced,
                        source: 'error',
                        message: 'License server is unreachable.',
                        key: $licenseKey,
                    );
                }
            },
        );
    }

    /**
     * @return array{
     *     enabled: bool,
     *     valid: bool,
     *     enforced: bool,
     *     source: string,
     *     message: string,
     *     key_last4: string|null,
     *     checked_at: string
     * }
     */
    private function status(
        bool $enabled,
        bool $valid,
        bool $enforced,
        string $source,
        string $message,
        ?string $key,
    ): array {
        return [
            'enabled' => $enabled,
            'valid' => $valid,
            'enforced' => $enforced,
            'source' => $source,
            'message' => $message,
            'key_last4' => $key ? substr($key, -4) : null,
            'checked_at' => now()->toIso8601String(),
        ];
    }
}
