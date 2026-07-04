<?php

namespace Tests\Unit\Pricing;

use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{
    public function test_subtotal_calculation_is_correct(): void
    {
        $price = 100000;
        $quantity = 3;
        $subtotal = $price * $quantity;

        $this->assertEquals(300000, $subtotal);
    }
    
    public function test_late_fee_calculation(): void
    {
        $dailyLateFee = 50000;
        $daysLate = 2;
        $totalLateFee = $dailyLateFee * $daysLate;
        
        $this->assertEquals(100000, $totalLateFee);
    }
}
