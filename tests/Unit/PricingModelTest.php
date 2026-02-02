<?php

namespace Tests\Unit;

use App\Models\Pricing;
use PHPUnit\Framework\TestCase;

class PricingModelTest extends TestCase
{
    protected Pricing $pricing;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pricing = new Pricing();
    }

    public function test_cost_as_per_month_returns_same_for_monthly_term()
    {
        $this->assertEquals(10.00, $this->pricing->costAsPerMonth('10.00', 1));
    }

    public function test_cost_as_per_month_divides_by_3_for_quarterly_term()
    {
        $result = $this->pricing->costAsPerMonth('30.00', 2);
        $this->assertEquals(10.00, $result);
    }

    public function test_cost_as_per_month_divides_by_6_for_semi_annual_term()
    {
        $result = $this->pricing->costAsPerMonth('60.00', 3);
        $this->assertEquals(10.00, $result);
    }

    public function test_cost_as_per_month_divides_by_12_for_annual_term()
    {
        $result = $this->pricing->costAsPerMonth('120.00', 4);
        $this->assertEquals(10.00, $result);
    }

    public function test_cost_as_per_month_divides_by_24_for_biennial_term()
    {
        $result = $this->pricing->costAsPerMonth('240.00', 5);
        $this->assertEquals(10.00, $result);
    }

    public function test_cost_as_per_month_divides_by_36_for_triennial_term()
    {
        $result = $this->pricing->costAsPerMonth('360.00', 6);
        $this->assertEquals(10.00, $result);
    }

    public function test_term_as_months_returns_1_for_monthly()
    {
        $this->assertEquals(1, $this->pricing->termAsMonths(1));
    }

    public function test_term_as_months_returns_3_for_quarterly()
    {
        $this->assertEquals(3, $this->pricing->termAsMonths(2));
    }

    public function test_term_as_months_returns_6_for_semi_annual()
    {
        $this->assertEquals(6, $this->pricing->termAsMonths(3));
    }

    public function test_term_as_months_returns_12_for_annual()
    {
        $this->assertEquals(12, $this->pricing->termAsMonths(4));
    }

    public function test_term_as_months_returns_24_for_biennial()
    {
        $this->assertEquals(24, $this->pricing->termAsMonths(5));
    }

    public function test_term_as_months_returns_36_for_triennial()
    {
        $this->assertEquals(36, $this->pricing->termAsMonths(6));
    }

    public function test_term_as_months_returns_62_for_unknown_term()
    {
        $this->assertEquals(62, $this->pricing->termAsMonths(99));
    }
}
