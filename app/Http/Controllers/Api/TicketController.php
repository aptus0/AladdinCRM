<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Ticket\StoreTicketRequest;
use App\Http\Requests\Api\Ticket\UpdateTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Ticket::class, 'ticket');
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $tickets = Ticket::query()
            ->with(['company:id,name', 'contact:id,first_name,last_name', 'assignedTo:id,name'])
            ->when(
                ! $user->isAdmin(),
                fn ($query) => $query->where(function ($inner) use ($user): void {
                    $inner->where('created_by', $user->id)
                        ->orWhere('assigned_to', $user->id);
                }),
            )
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where('status', (string) $request->string('status')),
            )
            ->when(
                $request->filled('priority'),
                fn ($query) => $query->where('priority', (string) $request->string('priority')),
            )
            ->when(
                $request->filled('q'),
                fn ($query) => $query->where('subject', 'like', '%'.$request->string('q').'%'),
            )
            ->latest('id')
            ->paginate((int) $request->integer('per_page', 15));

        return response()->json($tickets);
    }

    public function store(StoreTicketRequest $request): JsonResponse
    {
        $ticket = Ticket::query()->create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
            'status' => $request->input('status', 'open'),
            'priority' => $request->input('priority', 'medium'),
        ]);

        return response()->json($ticket->load(['company:id,name', 'contact:id,first_name,last_name', 'assignedTo:id,name']), 201);
    }

    public function show(Ticket $ticket): JsonResponse
    {
        return response()->json($ticket->load([
            'company:id,name',
            'contact:id,first_name,last_name',
            'assignedTo:id,name',
            'messages.user:id,name',
        ]));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $ticket->update($request->validated());

        return response()->json($ticket->fresh()->load(['company:id,name', 'contact:id,first_name,last_name', 'assignedTo:id,name']));
    }

    public function destroy(Ticket $ticket): JsonResponse
    {
        $ticket->delete();

        return response()->json(['message' => 'Ticket deleted']);
    }
}
