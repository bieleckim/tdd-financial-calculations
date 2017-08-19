<?php

namespace FinancialCalculations;

class Sum implements Expression
{
    public $augend;
    public $addend;

    public function __construct(Money $augend, Money $addend)
    {
        $this->augend = $augend;
        $this->addend = $addend;
    }

    public function reduce(Bank $bank, string $to) : Money
    {
        return new Money($this->augend->amount + $this->addend->amount, $to);
    }
}
