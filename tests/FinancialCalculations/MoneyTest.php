<?php

namespace Tests\FinancialCalculations;

use FinancialCalculations\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testMultiplication(): void
    {
        $dollar = Money::dollar(5);
        $this->assertEquals(Money::dollar(10), $dollar->times(2));
        $this->assertEquals(Money::dollar(15), $dollar->times(3));
    }

    public function testEquality(): void
    {
        $this->assertTrue(Money::dollar(10)->equals(Money::dollar(10)));
        $this->assertFalse(Money::dollar(10)->equals(Money::dollar(5)));
        $this->assertFalse(Money::franc(5)->equals(Money::dollar(5)));
    }

    public function testCurrency(): void
    {
        $this->assertEquals('USD', Money::dollar(1)->getCurrency());
        $this->assertEquals('CHF', Money::franc(1)->getCurrency());
    }
}
