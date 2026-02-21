<?php

namespace App\Services\Quotes;

use App\Data\Quotes\QuoteItemData;
use App\Services\Tax\TaxCalculatorInterface;

class QuoteTotalsCalculator
{
    public function __construct(
        protected TaxCalculatorInterface $taxCalculator,
    ) {
    }

    /**
     * @param  array<QuoteItemData>  $items
     * @return array{lines: array<int, array<string, float|int|string>>, totals: array<string, float>}
     */
    public function calculate(array $items): array
    {
        $lineResults = [];

        $subtotal = 0.0;
        $discountTotal = 0.0;
        $taxTotal = 0.0;
        $grandTotal = 0.0;

        foreach ($items as $item) {
            $lineSubtotal = round($item->quantity * $item->unitPrice, 2);
            $lineDiscountTotal = round(($lineSubtotal * $item->discountRate) / 100, 2);
            $taxableAmount = max($lineSubtotal - $lineDiscountTotal, 0);
            $lineTaxTotal = $this->taxCalculator->calculate($taxableAmount, $item->taxRate);
            $lineTotal = round($taxableAmount + $lineTaxTotal, 2);

            $lineResults[] = [
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unitPrice,
                'discount_rate' => $item->discountRate,
                'tax_rate' => $item->taxRate,
                'line_subtotal' => $lineSubtotal,
                'line_discount_total' => $lineDiscountTotal,
                'line_tax_total' => $lineTaxTotal,
                'line_total' => $lineTotal,
                'sort_order' => $item->sortOrder,
            ];

            $subtotal += $lineSubtotal;
            $discountTotal += $lineDiscountTotal;
            $taxTotal += $lineTaxTotal;
            $grandTotal += $lineTotal;
        }

        return [
            'lines' => $lineResults,
            'totals' => [
                'subtotal' => round($subtotal, 2),
                'discount_total' => round($discountTotal, 2),
                'tax_total' => round($taxTotal, 2),
                'grand_total' => round($grandTotal, 2),
            ],
        ];
    }
}
