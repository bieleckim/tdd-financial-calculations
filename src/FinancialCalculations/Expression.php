<?php

namespace FinancialCalculations;

interface Expression
{
    public function reduce(Bank $bank, string $to) : Money;

    public function sum(Expression $addend) : Sum;
}
