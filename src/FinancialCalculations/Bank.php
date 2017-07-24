<?php

namespace FinancialCalculations;

class Bank
{

	public function reduce(Expression $source, string $to) : Money
	{
		return $source->reduce($to);
	}

}
