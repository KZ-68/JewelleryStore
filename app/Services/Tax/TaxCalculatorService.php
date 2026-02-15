<?php

namespace App\Services\Tax;

class TaxCalculatorService
{
    /**
     * @param float $amount The price
     * @param float $rate The tax rate
     * @return float Return a rounded tax value
    */
    public function calculateTax(float $amount, float $rate = 0.20): float
    {
        return round($amount * $rate, 2);
    }

    /**
     * @param float $amount The price
     * @param float $rate The tax rate
     * @return float Return a rounded value for the retail price
    */
    public function withTax(float $amount, float $rate = 0.20): float
    {
        return round($amount + $this->calculateTax($amount, $rate), 2);
    }
}