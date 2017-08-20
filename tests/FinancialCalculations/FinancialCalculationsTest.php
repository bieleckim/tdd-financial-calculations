<?php

namespace Tests\FinancialCalculations;

use FinancialCalculations\Bank;
use FinancialCalculations\Money;
use FinancialCalculations\Sum;
use PHPUnit\Framework\TestCase;

class FinancialCalculationsTest extends TestCase
{
    public function testSimpleAddition(): void
    {
        $five    = Money::dollar(5);
        $sum     = $five->plus($five);
        $bank    = new Bank();
        $reduced = $bank->reduce($sum, "USD");
        $this->assertEquals(Money::dollar(10), $reduced);
    }

    public function testPlusReturnsSum(): void
    {
        $five   = Money::dollar(5);
        $result = $five->plus($five);
        $this->assertEquals($five, $result->augend);
        $this->assertEquals($five, $result->addend);
    }

    public function testReduceSum(): void
    {
        $sum    = new Sum(Money::dollar(3), Money::dollar(4));
        $bank   = new Bank();
        $result = $bank->reduce($sum, "USD");
        $this->assertEquals(Money::dollar(7), $result);
    }

    public function testReduceMoney(): void
    {
        $bank   = new Bank();
        $result = $bank->reduce(Money::dollar(1), 'USD');
        $this->assertEquals(Money::dollar(1), $result);
    }

    public function testReduceMoneyDifferentCurrency(): void
    {
        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);
        $result = $bank->reduce(Money::franc(2), 'USD');
        $this->assertEquals(Money::dollar(1), $result);
    }

    public function testIdentityRate(): void
    {
        $this->assertEquals(1, (new Bank())->rate('USD', 'USD'));
    }

    public function testMixedAddition(): void
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);

        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);

        $result = $bank->reduce($fiveBucks->plus($tenFrancs), 'USD');
        $this->assertEquals(Money::dollar(10), $result);
    }

    public function testSumPlusMoney(): void
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);

        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);

        $sum    = (new Sum($fiveBucks, $tenFrancs))->plus($fiveBucks);
        $result = $bank->reduce($sum, 'USD');
        $this->assertEquals(Money::dollar(15), $result);
    }

    public function testSumTimes(): void
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);

        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);

        $sum    = (new Sum($fiveBucks, $tenFrancs))->times(2);
        $result = $bank->reduce($sum, 'USD');
        $this->assertEquals(Money::dollar(20), $result);
    }
}
