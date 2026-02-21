<?php

namespace App\Data\Quotes;

class QuoteItemData
{
    public function __construct(
        public readonly string $description,
        public readonly float $quantity,
        public readonly float $unitPrice,
        public readonly float $discountRate,
        public readonly float $taxRate,
        public readonly int $sortOrder,
    ) {
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromArray(array $payload, int $sortOrder): self
    {
        return new self(
            description: (string) $payload['description'],
            quantity: (float) $payload['quantity'],
            unitPrice: (float) $payload['unit_price'],
            discountRate: (float) ($payload['discount_rate'] ?? 0),
            taxRate: (float) ($payload['tax_rate'] ?? 20),
            sortOrder: $sortOrder,
        );
    }
}
