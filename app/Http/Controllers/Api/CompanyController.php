<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Company\StoreCompanyRequest;
use App\Http\Requests\Api\Company\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $companies = Company::query()
            ->when(
                ! $user->isAdmin(),
                fn ($query) => $query->where('created_by', $user->id),
            )
            ->when(
                $request->filled('q'),
                function ($query) use ($request): void {
                    $search = (string) $request->string('q');

                    $query->where(function ($innerQuery) use ($search): void {
                        $innerQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('industry', 'like', "%{$search}%");
                    });
                },
            )
            ->latest('id')
            ->paginate((int) $request->integer('per_page', 15));

        return response()->json($companies);
    }

    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $company = Company::query()->create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        return response()->json($company, 201);
    }

    public function show(Company $company): JsonResponse
    {
        return response()->json($company->loadCount(['contacts', 'opportunities', 'quotes', 'tasks', 'tickets']));
    }

    public function update(UpdateCompanyRequest $request, Company $company): JsonResponse
    {
        $company->update($request->validated());

        return response()->json($company->fresh());
    }

    public function destroy(Company $company): JsonResponse
    {
        $company->delete();

        return response()->json(['message' => 'Company deleted']);
    }
}
