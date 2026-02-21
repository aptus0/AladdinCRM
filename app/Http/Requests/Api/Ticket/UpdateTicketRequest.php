<?php

namespace App\Http\Requests\Api\Ticket;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'company_id' => ['sometimes', 'nullable', 'integer', 'exists:companies,id'],
            'contact_id' => ['sometimes', 'nullable', 'integer', 'exists:contacts,id'],
            'assigned_to' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'subject' => ['sometimes', 'required', 'string', 'max:255'],
            'priority' => ['sometimes', 'required', Rule::in(TicketPriority::values())],
            'status' => ['sometimes', 'required', Rule::in(TicketStatus::values())],
        ];
    }
}
