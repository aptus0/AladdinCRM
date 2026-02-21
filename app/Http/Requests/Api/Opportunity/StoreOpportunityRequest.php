<?php

namespace App\Http\Requests\Api\Opportunity;

use App\Enums\OpportunityStage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOpportunityRequest extends FormRequest
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
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'title' => ['required', 'string', 'max:255'],
            'stage' => ['required', Rule::in(OpportunityStage::values())],
            'amount' => ['required', 'numeric', 'min:0'],
            'close_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
