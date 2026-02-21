<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\License\LicenseVerifier;
use App\Support\System\VersionChecker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SystemStatusController extends Controller
{
    public function __invoke(
        Request $request,
        LicenseVerifier $licenseVerifier,
        VersionChecker $versionChecker,
    ): JsonResponse {
        $currentVersion = (string) config('app.version', '1.0.0');

        return response()->json([
            'app' => [
                'name' => (string) config('app.name'),
                'version' => $currentVersion,
                'environment' => (string) app()->environment(),
            ],
            'license' => $licenseVerifier->verify(
                domain: $request->getHost(),
                appVersion: $currentVersion,
            ),
            'version' => $versionChecker->check($currentVersion),
        ]);
    }
}
