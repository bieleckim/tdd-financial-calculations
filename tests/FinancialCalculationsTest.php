<?php

namespace Tests;

use FinancialCalculations\Bank;
use FinancialCalculations\Money;
use FinancialCalculations\Sum;
use PHPUnit\Framework\TestCase;

class FinancialCalculationsTest extends TestCase
{
    public function testMultiplication()
    {
        $dollar = Money::dollar(5);
        $this->assertEquals(Money::dollar(10), $dollar->times(2));
        $this->assertEquals(Money::dollar(15), $dollar->times(3));
    }

    public function testEquality()
    {
        $this->assertTrue(Money::dollar(10)->equals(Money::dollar(10)));
        $this->assertFalse(Money::dollar(10)->equals(Money::dollar(5)));
        $this->assertFalse(Money::franc(5)->equals(Money::dollar(5)));
    }

    public function testCurrency()
    {
        $this->assertEquals('USD', Money::dollar(1)->getCurrency());
        $this->assertEquals('CHF', Money::franc(1)->getCurrency());
    }

    public function testSimpleAddition()
    {
        $five    = Money::dollar(5);
        $sum     = $five->plus($five);
        $bank    = new Bank();
        $reduced = $bank->reduce($sum, "USD");
        $this->assertEquals(Money::dollar(10), $reduced);
    }

    public function testPlusReturnsSum()
    {
        $five   = Money::dollar(5);
        $result = $five->plus($five);
        $this->assertEquals($five, $result->augend);
        $this->assertEquals($five, $result->addend);
    }

    public function testReduceSum()
    {
        $sum    = new Sum(Money::dollar(3), Money::dollar(4));
        $bank   = new Bank();
        $result = $bank->reduce($sum, "USD");
        $this->assertEquals(Money::dollar(7), $result);
    }

    public function testReduceMoney()
    {
        $bank   = new Bank();
        $result = $bank->reduce(Money::dollar(1), 'USD');
        $this->assertEquals(Money::dollar(1), $result);
    }

    public function testReduceMoneyDifferentCurrency()
    {
        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);
        $result = $bank->reduce(Money::franc(2), 'USD');
        $this->assertEquals(Money::dollar(1), $result);
    }

    public function testIdentityRate()
    {
        $this->assertEquals(1, (new Bank())->rate('USD', 'USD'));
    }
}
