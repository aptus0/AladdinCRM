<?php

namespace App\Support\System;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class VersionChecker
{
    /**
     * @return array{
     *     current_version: string,
     *     latest_version: string|null,
     *     update_available: bool,
     *     source: string,
     *     message: string,
     *     download_url: string|null,
     *     notes_url: string|null,
     *     checked_at: string
     * }
     */
    public function check(string $currentVersion): array
    {
        $checkUrl = trim((string) config('version.check_url', ''));
        $cacheMinutes = max((int) config('version.cache_minutes', 30), 1);

        if ($checkUrl === '') {
            return $this->status(
                currentVersion: $currentVersion,
                latestVersion: null,
                updateAvailable: false,
                source: 'disabled',
                message: 'Version check URL not configured.',
                downloadUrl: null,
                notesUrl: null,
            );
        }

        $cacheKey = sprintf('version:check:%s', sha1($checkUrl.'|'.$currentVersion));

        return Cache::remember(
            $cacheKey,
            Carbon::now()->addMinutes($cacheMinutes),
            function () use ($checkUrl, $currentVersion): array {
                try {
                    $timeout = max((int) config('version.timeout_seconds', 3), 1);

                    $response = Http::timeout($timeout)
                        ->acceptJson()
                        ->get($checkUrl, [
                            'current_version' => $currentVersion,
                            'app_name' => (string) config('app.name'),
                        ]);

                    if (! $response->ok()) {
                        return $this->status(
                            currentVersion: $currentVersion,
                            latestVersion: null,
                            updateAvailable: false,
                            source: 'remote',
                            message: sprintf('Version server error (%d).', $response->status()),
                            downloadUrl: null,
                            notesUrl: null,
                        );
                    }

                    $payload = (array) $response->json();
                    $latestVersion = isset($payload['latest_version']) ? (string) $payload['latest_version'] : null;
                    $downloadUrl = isset($payload['download_url']) ? (string) $payload['download_url'] : null;
                    $notesUrl = isset($payload['notes_url']) ? (string) $payload['notes_url'] : null;
                    $message = isset($payload['message']) ? (string) $payload['message'] : 'Version checked.';

                    $updateAvailable = $latestVersion !== null
                        && $latestVersion !== ''
                        && version_compare($latestVersion, $currentVersion, '>');

                    return $this->status(
                        currentVersion: $currentVersion,
                        latestVersion: $latestVersion,
                        updateAvailable: $updateAvailable,
                        source: 'remote',
                        message: $message,
                        downloadUrl: $downloadUrl,
                        notesUrl: $notesUrl,
                    );
                } catch (Throwable $exception) {
                    return $this->status(
                        currentVersion: $currentVersion,
                        latestVersion: null,
                        updateAvailable: false,
                        source: 'error',
                        message: 'Version server is unreachable.',
                        downloadUrl: null,
                        notesUrl: null,
                    );
                }
            },
        );
    }

    /**
     * @return array{
     *     current_version: string,
     *     latest_version: string|null,
     *     update_available: bool,
     *     source: string,
     *     message: string,
     *     download_url: string|null,
     *     notes_url: string|null,
     *     checked_at: string
     * }
     */
    private function status(
        string $currentVersion,
        ?string $latestVersion,
        bool $updateAvailable,
        string $source,
        string $message,
        ?string $downloadUrl,
        ?string $notesUrl,
    ): array {
        return [
            'current_version' => $currentVersion,
            'latest_version' => $latestVersion,
            'update_available' => $updateAvailable,
            'source' => $source,
            'message' => $message,
            'download_url' => $downloadUrl,
            'notes_url' => $notesUrl,
            'checked_at' => now()->toIso8601String(),
        ];
    }
}
