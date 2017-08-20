<?php

namespace FinancialCalculations;

interface Expression
{
    public function reduce(Bank $bank, string $to) : Money;

    public function times(int $multiplier) : Expression;
}
