<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Ticket\StoreTicketMessageRequest;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\JsonResponse;

class TicketMessageController extends Controller
{
    public function store(StoreTicketMessageRequest $request, Ticket $ticket): JsonResponse
    {
        $this->authorize('view', $ticket);

        $message = TicketMessage::query()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'message' => $request->string('message')->toString(),
            'is_internal' => (bool) $request->boolean('is_internal', false),
        ]);

        return response()->json($message->load('user:id,name'), 201);
    }
}
