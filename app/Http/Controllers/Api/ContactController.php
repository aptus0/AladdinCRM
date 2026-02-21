<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contact\StoreContactRequest;
use App\Http\Requests\Api\Contact\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Contact::class, 'contact');
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $contacts = Contact::query()
            ->with('company:id,name')
            ->when(
                ! $user->isAdmin(),
                fn ($query) => $query->where(function ($inner) use ($user): void {
                    $inner->where('created_by', $user->id)
                        ->orWhereHas('company', fn ($companyQuery) => $companyQuery->where('created_by', $user->id));
                }),
            )
            ->when(
                $request->filled('company_id'),
                fn ($query) => $query->where('company_id', (int) $request->integer('company_id')),
            )
            ->when(
                $request->filled('q'),
                function ($query) use ($request): void {
                    $search = (string) $request->string('q');

                    $query->where(function ($innerQuery) use ($search): void {
                        $innerQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('title', 'like', "%{$search}%");
                    });
                },
            )
            ->latest('id')
            ->paginate((int) $request->integer('per_page', 15));

        return response()->json($contacts);
    }

    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = Contact::query()->create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        return response()->json($contact->load('company:id,name'), 201);
    }

    public function show(Contact $contact): JsonResponse
    {
        return response()->json($contact->load('company:id,name'));
    }

    public function update(UpdateContactRequest $request, Contact $contact): JsonResponse
    {
        $contact->update($request->validated());

        return response()->json($contact->fresh()->load('company:id,name'));
    }

    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();

        return response()->json(['message' => 'Contact deleted']);
    }
}
