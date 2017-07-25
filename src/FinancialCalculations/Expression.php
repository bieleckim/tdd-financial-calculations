<?php

namespace FinancialCalculations;

interface Expression
{
    public function reduce(string $to) : Money;
}
