<?php

namespace FinancialCalculations;

class Bank
{
    private $rates = [];

    public function reduce(Expression $source, string $to) : Money
    {
        return $source->reduce($this, $to);
    }

    public function rate(string $from, string $to) : int
    {
        if ($from === $to) {
            return 1;
        }

        return $this->rates[$from . $to];
    }

    public function addRate(string $from, string $to, int $rate) : void
    {
        $this->rates[$from . $to] = $rate;
    }
}
