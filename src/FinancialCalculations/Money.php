<?php

namespace FinancialCalculations;

class Money implements Expression
{
    public $amount;

    protected $currency;

    public function __construct(int $amount, string $currency)
    {
        $this->amount   = $amount;
        $this->currency = $currency;
    }

    public static function createDollar(int $amount) : Money
    {
        return new Money($amount, 'USD');
    }

    public static function createFranc(int $amount) : Money
    {
        return new Money($amount, 'CHF');
    }

    public function equals(Money $money) : bool
    {
        return $this->amount === $money->amount &&
               $this->getCurrency() === $money->getCurrency();
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function times(int $multiplier) : Money
    {
        return new Money($this->amount * $multiplier, $this->currency);
    }

    public function plus(Money $money) : Expression
    {
        return new Sum($this, $money);
    }

    public function __toString() : string
    {
        return $this->amount . ' ' . $this->currency;
    }

    public function reduce(string $to) : Money
    {
        return $this;
    }
}
