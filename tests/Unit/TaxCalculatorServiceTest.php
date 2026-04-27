<?php

namespace Tests\Unit;

use App\Services\Tax\TaxCalculatorService;
use PHPUnit\Framework\TestCase;

class TaxCalculatorServiceTest extends TestCase
{
    private TaxCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TaxCalculatorService();
    }

    public function test_calculateTax_returns_correct_amount_with_default_rate(): void
    {
        $this->assertSame(20.0, $this->service->calculateTax(100.0));
    }

    public function test_calculateTax_returns_correct_amount_with_custom_rate(): void
    {
        $this->assertSame(5.0, $this->service->calculateTax(50.0, 0.10));
    }

    public function test_calculateTax_rounds_to_two_decimal_places(): void
    {
        $this->assertSame(6.67, $this->service->calculateTax(33.33));
    }

    public function test_calculateTax_with_zero_amount_returns_zero(): void
    {
        $this->assertSame(0.0, $this->service->calculateTax(0.0));
    }

    public function test_calculateTax_with_zero_rate_returns_zero(): void
    {
        $this->assertSame(0.0, $this->service->calculateTax(100.0, 0.0));
    }

    public function test_withTax_returns_amount_plus_tax_with_default_rate(): void
    {
        $this->assertSame(120.0, $this->service->withTax(100.0));
    }

    public function test_withTax_returns_amount_plus_tax_with_custom_rate(): void
    {
        $this->assertSame(220.0, $this->service->withTax(200.0, 0.10));
    }

    public function test_withTax_rounds_to_two_decimal_places(): void
    {
        $this->assertSame(40.0, $this->service->withTax(33.33));
    }

    public function test_withTax_with_zero_rate_returns_original_amount(): void
    {
        $this->assertSame(99.99, $this->service->withTax(99.99, 0.0));
    }
}
