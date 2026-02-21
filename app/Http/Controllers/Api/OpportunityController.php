<?php

namespace App\Http\Controllers\Api;

use App\Enums\OpportunityStage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Opportunity\StoreOpportunityRequest;
use App\Http\Requests\Api\Opportunity\UpdateOpportunityRequest;
use App\Models\Opportunity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Opportunity::class, 'opportunity');
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $opportunities = Opportunity::query()
            ->with('company:id,name')
            ->when(
                ! $user->isAdmin(),
                fn ($query) => $query->where('created_by', $user->id),
            )
            ->when(
                $request->filled('stage'),
                fn ($query) => $query->where('stage', (string) $request->string('stage')),
            )
            ->when(
                $request->filled('company_id'),
                fn ($query) => $query->where('company_id', (int) $request->integer('company_id')),
            )
            ->when(
                $request->filled('q'),
                fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%'),
            )
            ->latest('id')
            ->paginate((int) $request->integer('per_page', 15));

        return response()->json($opportunities);
    }

    public function pipelineSummary(Request $request): JsonResponse
    {
        $user = $request->user();

        $baseQuery = Opportunity::query()->when(
            ! $user->isAdmin(),
            fn ($query) => $query->where('created_by', $user->id),
        );

        $byStage = OpportunityStage::cases();
        $stageTotals = [];

        foreach ($byStage as $stage) {
            $stageTotals[$stage->value] = (float) (clone $baseQuery)
                ->where('stage', $stage->value)
                ->sum('amount');
        }

        return response()->json([
            'total_pipeline' => (float) (clone $baseQuery)->sum('amount'),
            'stage_distribution' => $stageTotals,
        ]);
    }

    public function store(StoreOpportunityRequest $request): JsonResponse
    {
        $opportunity = Opportunity::query()->create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        return response()->json($opportunity->load('company:id,name'), 201);
    }

    public function show(Opportunity $opportunity): JsonResponse
    {
        return response()->json($opportunity->load('company:id,name'));
    }

    public function update(UpdateOpportunityRequest $request, Opportunity $opportunity): JsonResponse
    {
        $opportunity->update($request->validated());

        return response()->json($opportunity->fresh()->load('company:id,name'));
    }

    public function destroy(Opportunity $opportunity): JsonResponse
    {
        $opportunity->delete();

        return response()->json(['message' => 'Opportunity deleted']);
    }
}
