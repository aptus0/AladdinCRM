<?php

namespace App\Services\Tax;

class TrVatCalculator implements TaxCalculatorInterface
{
    public function calculate(float $baseAmount, float $rate): float
    {
        return round(($baseAmount * $rate) / 100, 2);
    }
}
