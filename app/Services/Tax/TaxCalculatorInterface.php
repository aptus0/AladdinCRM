<?php

namespace App\Services\Tax;

interface TaxCalculatorInterface
{
    public function calculate(float $baseAmount, float $rate): float;
}
