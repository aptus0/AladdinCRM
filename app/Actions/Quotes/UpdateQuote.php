<?php

namespace App\Actions\Quotes;

use App\Data\Quotes\QuoteData;
use App\Enums\ActivityAction;
use App\Models\Quote;
use App\Services\Quotes\QuoteTotalsCalculator;
use App\Support\ActivityLogger;
use Illuminate\Support\Facades\DB;

class UpdateQuote
{
    public function __construct(
        protected QuoteTotalsCalculator $totalsCalculator,
    ) {
    }

    public function handle(Quote $quote, QuoteData $data): Quote
    {
        return DB::transaction(function () use ($quote, $data): Quote {
            $beforeTotal = (float) $quote->grand_total;
            $totals = $this->totalsCalculator->calculate($data->items);

            $quote->update([
                'company_id' => $data->companyId,
                'opportunity_id' => $data->opportunityId,
                'currency' => $data->currency,
                'status' => $data->status,
                'note' => $data->note,
                ...$totals['totals'],
            ]);

            $quote->items()->delete();
            $quote->items()->createMany($totals['lines']);

            if ($beforeTotal !== (float) $quote->grand_total) {
                ActivityLogger::logCustom(
                    $quote,
                    ActivityAction::Updated,
                    sprintf('Quote #%s total changed from %.2f to %.2f', $quote->quote_number, $beforeTotal, (float) $quote->grand_total),
                    [
                        'before_total' => $beforeTotal,
                        'after_total' => (float) $quote->grand_total,
                    ],
                );
            }

            return $quote->load(['items', 'company', 'opportunity', 'createdBy']);
        });
    }
}
