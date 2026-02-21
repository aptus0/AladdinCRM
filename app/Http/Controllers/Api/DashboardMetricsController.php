<?php

namespace App\Http\Controllers\Api;

use App\Actions\Dashboard\GetDashboardMetrics;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardMetricsController extends Controller
{
    public function __invoke(Request $request, GetDashboardMetrics $getDashboardMetrics): JsonResponse
    {
        return response()->json($getDashboardMetrics->handle($request->user()));
    }
}
