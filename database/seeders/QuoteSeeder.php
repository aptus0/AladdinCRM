<?php

namespace Database\Seeders;

use App\Enums\OpportunityStage;
use App\Enums\QuoteCurrency;
use App\Enums\QuoteStatus;
use App\Models\Opportunity;
use App\Models\Quote;
use App\Models\QuoteItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $opportunities = Opportunity::query()
            ->whereIn('stage', [
                OpportunityStage::Qualified,
                OpportunityStage::Proposal,
                OpportunityStage::Negotiation,
                OpportunityStage::Won,
            ])
            ->orderBy('id')
            ->get();

        $currencies = [QuoteCurrency::Try, QuoteCurrency::Usd, QuoteCurrency::Eur];

        foreach ($opportunities as $index => $opportunity) {
            $currency = $currencies[$index % count($currencies)];
            $status = $this->resolveStatus($opportunity->stage);
            $quoteNumber = sprintf('Q-2026-%04d', $opportunity->id);

            $quote = Quote::query()->updateOrCreate(
                ['quote_number' => $quoteNumber],
                [
                    'company_id' => $opportunity->company_id,
                    'opportunity_id' => $opportunity->id,
                    'created_by' => $opportunity->created_by,
                    'currency' => $currency,
                    'status' => $status,
                    'note' => 'Seeder tarafindan olusturulan teklif kaydi.',
                    'subtotal' => 0,
                    'discount_total' => 0,
                    'tax_total' => 0,
                    'grand_total' => 0,
                ],
            );

            $amount = max((float) $opportunity->amount, 5000.0);
            $items = $this->buildItems($amount);

            $totals = [
                'subtotal' => 0.0,
                'discount_total' => 0.0,
                'tax_total' => 0.0,
                'grand_total' => 0.0,
            ];

            foreach ($items as $itemIndex => $item) {
                $line = $this->calculateLineTotals(
                    quantity: $item['quantity'],
                    unitPrice: $item['unit_price'],
                    discountRate: $item['discount_rate'],
                    taxRate: $item['tax_rate'],
                );

                QuoteItem::query()->updateOrCreate(
                    [
                        'quote_id' => $quote->id,
                        'sort_order' => $itemIndex + 1,
                    ],
                    [
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'discount_rate' => $item['discount_rate'],
                        'tax_rate' => $item['tax_rate'],
                        'line_subtotal' => $line['line_subtotal'],
                        'line_discount_total' => $line['line_discount_total'],
                        'line_tax_total' => $line['line_tax_total'],
                        'line_total' => $line['line_total'],
                    ],
                );

                $totals['subtotal'] += $line['line_subtotal'];
                $totals['discount_total'] += $line['line_discount_total'];
                $totals['tax_total'] += $line['line_tax_total'];
                $totals['grand_total'] += $line['line_total'];
            }

            QuoteItem::query()
                ->where('quote_id', $quote->id)
                ->whereNotIn('sort_order', [1, 2, 3])
                ->delete();

            $quote->update([
                'subtotal' => round($totals['subtotal'], 2),
                'discount_total' => round($totals['discount_total'], 2),
                'tax_total' => round($totals['tax_total'], 2),
                'grand_total' => round($totals['grand_total'], 2),
            ]);
        }
    }

    private function resolveStatus(OpportunityStage $stage): QuoteStatus
    {
        return match ($stage) {
            OpportunityStage::Qualified => QuoteStatus::Draft,
            OpportunityStage::Proposal, OpportunityStage::Negotiation => QuoteStatus::Sent,
            OpportunityStage::Won => QuoteStatus::Accepted,
            default => QuoteStatus::Draft,
        };
    }

    /**
     * @return list<array{description: string, quantity: float, unit_price: float, discount_rate: float, tax_rate: float}>
     */
    private function buildItems(float $amount): array
    {
        $analysis = round($amount * 0.2, 2);
        $implementation = round($amount * 0.6, 2);
        $training = round($amount * 0.2, 2);

        return [
            [
                'description' => 'Analiz ve Onboarding',
                'quantity' => 1,
                'unit_price' => $analysis,
                'discount_rate' => 0,
                'tax_rate' => 20,
            ],
            [
                'description' => 'Uygulama ve Entegrasyon',
                'quantity' => 1,
                'unit_price' => $implementation,
                'discount_rate' => 5,
                'tax_rate' => 20,
            ],
            [
                'description' => 'Egitim ve 30 Gun Destek',
                'quantity' => 1,
                'unit_price' => $training,
                'discount_rate' => 0,
                'tax_rate' => 20,
            ],
        ];
    }

    /**
     * @return array{line_subtotal: float, line_discount_total: float, line_tax_total: float, line_total: float}
     */
    private function calculateLineTotals(float $quantity, float $unitPrice, float $discountRate, float $taxRate): array
    {
        $lineSubtotal = round($quantity * $unitPrice, 2);
        $lineDiscountTotal = round($lineSubtotal * ($discountRate / 100), 2);
        $taxable = $lineSubtotal - $lineDiscountTotal;
        $lineTaxTotal = round($taxable * ($taxRate / 100), 2);
        $lineTotal = round($taxable + $lineTaxTotal, 2);

        return [
            'line_subtotal' => $lineSubtotal,
            'line_discount_total' => $lineDiscountTotal,
            'line_tax_total' => $lineTaxTotal,
            'line_total' => $lineTotal,
        ];
    }
}
