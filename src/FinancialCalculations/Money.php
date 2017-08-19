<?php

namespace FinancialCalculations;

class Money implements Expression
{
    /**
     * @var int
     */
    public $amount;

    /**
     * @var string
     */
    protected $currency;

    public function __construct(int $amount, string $currency)
    {
        $this->amount   = $amount;
        $this->currency = $currency;
    }

    public static function dollar(int $amount) : Money
    {
        return new Money($amount, 'USD');
    }

    public static function franc(int $amount) : Money
    {
        return new Money($amount, 'CHF');
    }

    public function equals(Money $money) : bool
    {
        return $this->amount === $money->amount &&
               $this->getCurrency() === $money->getCurrency();
    }

    public function getCurrency() : string
    {
        return $this->currency;
    }

    public function times(int $multiplier) : Expression
    {
        return new Money($this->amount * $multiplier, $this->currency);
    }

    public function plus(Expression $money) : Sum
    {
        return new Sum($this, $money);
    }

    public function __toString() : string
    {
        return $this->amount . ' ' . $this->currency;
    }

    public function reduce(Bank $bank, string $to) : Money
    {
        $rate = $bank->rate($this->currency, $to);
        return new Money($this->amount / $rate, $to);
    }

    public function sum(Expression $addend): Sum
    {
        return new Sum($this, $addend);
    }
}
