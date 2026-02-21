<?php

namespace App\Support;

use App\Models\Quote;

class QuoteNumberGenerator
{
    public function generate(): string
    {
        $year = now()->format('Y');
        $prefix = 'Q-'.$year.'-';

        $latestQuote = Quote::query()
            ->where('quote_number', 'like', $prefix.'%')
            ->latest('id')
            ->first();

        if (! $latestQuote) {
            return $prefix.'001';
        }

        $lastSequence = (int) substr($latestQuote->quote_number, -3);

        return $prefix.str_pad((string) ($lastSequence + 1), 3, '0', STR_PAD_LEFT);
    }
}
