<?php

use FinancialCalculations\Bank;
use FinancialCalculations\Sum;
use FinancialCalculations\Money;
use PHPUnit\Framework\TestCase;

class FinancialCalculationsTest extends TestCase
{

	public function testMultiplication()
	{
		$dollar = Money::createDollar(5);
		$this->assertEquals(Money::createDollar(10), $dollar->times(2));
		$this->assertEquals(Money::createDollar(15), $dollar->times(3));
	}

	public function testEquality()
	{
		$this->assertTrue(Money::createDollar(10)->equals(Money::createDollar(10)));
		$this->assertFalse(Money::createDollar(10)->equals(Money::createDollar(5)));
		$this->assertFalse(Money::createFranc(5)->equals(Money::createDollar(5)));
	}

	public function testCurrency()
	{
		$this->assertEquals('USD', Money::createDollar(1)->getCurrency());
		$this->assertEquals('CHF', Money::createFranc(1)->getCurrency());
	}

	public function testSimpleAddition()
	{
		$five = Money::createDollar(5);
		$sum = $five->plus($five);
		$bank = new Bank();
		$reduced = $bank->reduce($sum, "USD");
		$this->assertEquals(Money::createDollar(10), $reduced);
	}

	public function testPlusReturnsSum()
	{
		$five = Money::createDollar(5);
		$result = $five->plus($five);
		$this->assertEquals($five, $result->augend);
		$this->assertEquals($five, $result->addend);
	}

	public function testReduceSum()
	{
		$sum = new Sum(Money::createDollar(3), Money::createDollar(4));
		$bank = new Bank();
		$result = $bank->reduce($sum, "USD");
		$this->assertEquals(Money::createDollar(7), $result);
	}

	public function testReduceMoney()
	{
		$bank = new Bank();
		$result = $bank->reduce(Money::createDollar(1), 'USD');
		$this->assertEquals(Money::createDollar(1), $result);
	}

}
