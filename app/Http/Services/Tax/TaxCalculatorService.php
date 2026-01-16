<?php

namespace App\Http\Services\Tax;

class TaxCalculatorService
{
    public function calculateTax(float $amount, float $rate = 0.20): float
    {
        return round($amount * $rate, 2);
    }

    public function withTax(float $amount, float $rate = 0.20): float
    {
        return round($amount + $this->calculateTax($amount, $rate), 2);
    }
}