<?php

namespace App\Http\Middleware;

use App\Support\License\LicenseVerifier;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLicenseIsValid
{
    public function __construct(
        private readonly LicenseVerifier $licenseVerifier,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (app()->runningInConsole()) {
            return $next($request);
        }

        $status = $this->licenseVerifier->verify(
            domain: $request->getHost(),
            appVersion: (string) config('app.version', '1.0.0'),
        );

        if (! $status['valid'] && $status['enforced']) {
            return $this->failedResponse($request, $status['message']);
        }

        /** @var Response $response */
        $response = $next($request);
        $response->headers->set('X-App-Version', (string) config('app.version', '1.0.0'));
        $response->headers->set('X-License-Status', $status['valid'] ? 'valid' : 'warning');

        return $response;
    }

    private function failedResponse(Request $request, string $message): Response
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return new JsonResponse([
                'message' => $message,
            ], 403);
        }

        abort(403, $message);
    }
}
