<?php

namespace App\Service;

use App\DTO\Transaction;

interface CommissionCalculatorInterface
{
    public function calculate(Transaction $transaction): float;
}
