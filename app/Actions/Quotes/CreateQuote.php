<?php

namespace App\Actions\Quotes;

use App\Data\Quotes\QuoteData;
use App\Models\Quote;
use App\Models\User;
use App\Services\Quotes\QuoteTotalsCalculator;
use App\Support\QuoteNumberGenerator;
use Illuminate\Support\Facades\DB;

class CreateQuote
{
    public function __construct(
        protected QuoteTotalsCalculator $totalsCalculator,
        protected QuoteNumberGenerator $quoteNumberGenerator,
    ) {
    }

    public function handle(QuoteData $data, User $actor): Quote
    {
        return DB::transaction(function () use ($data, $actor): Quote {
            $totals = $this->totalsCalculator->calculate($data->items);

            $quote = Quote::query()->create([
                'company_id' => $data->companyId,
                'opportunity_id' => $data->opportunityId,
                'created_by' => $actor->id,
                'quote_number' => $this->quoteNumberGenerator->generate(),
                'currency' => $data->currency,
                'status' => $data->status,
                'note' => $data->note,
                ...$totals['totals'],
            ]);

            $quote->items()->createMany($totals['lines']);

            return $quote->load(['items', 'company', 'opportunity', 'createdBy']);
        });
    }
}
