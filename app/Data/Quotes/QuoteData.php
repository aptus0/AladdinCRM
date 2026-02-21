<?php

namespace App\Data\Quotes;

use App\Enums\QuoteCurrency;
use App\Enums\QuoteStatus;

class QuoteData
{
    /**
     * @param  array<QuoteItemData>  $items
     */
    public function __construct(
        public readonly int $companyId,
        public readonly ?int $opportunityId,
        public readonly QuoteCurrency $currency,
        public readonly QuoteStatus $status,
        public readonly ?string $note,
        public readonly array $items,
    ) {
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromArray(array $payload): self
    {
        $items = [];

        foreach ($payload['items'] ?? [] as $index => $itemPayload) {
            $items[] = QuoteItemData::fromArray((array) $itemPayload, $index + 1);
        }

        return new self(
            companyId: (int) $payload['company_id'],
            opportunityId: isset($payload['opportunity_id']) ? (int) $payload['opportunity_id'] : null,
            currency: QuoteCurrency::from((string) $payload['currency']),
            status: QuoteStatus::from((string) ($payload['status'] ?? QuoteStatus::Draft->value)),
            note: isset($payload['note']) ? (string) $payload['note'] : null,
            items: $items,
        );
    }
}
