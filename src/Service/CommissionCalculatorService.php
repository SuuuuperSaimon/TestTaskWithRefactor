<?php

namespace App\Service;

use App\DTO\Transaction;
use App\Enum\CommissionRateEnum as CommissionRate;

class CommissionCalculatorService implements CommissionCalculatorInterface
{
    public function __construct(
        private BinProviderInterface $binProvider,
        private ExchangeRateProviderInterface $exchangeRateProvider,
        private CountryValidatorInterface $countryValidator
    ) {}

    public function calculate(Transaction $transaction): float
    {
        $countryCode = $this->binProvider->getCountryCode($transaction->bin);
        $isEu = $this->countryValidator->isEu($countryCode);

        $rate = $transaction->currency === 'EUR'
            ? 1.0
            : $this->exchangeRateProvider->getRate($transaction->currency);

        $amountEur = $rate > 0 ? $transaction->amount / $rate : $transaction->amount;
        $commissionRate = $isEu ? CommissionRate::EU : CommissionRate::NON_EU;

        return ceil($amountEur * $commissionRate->rate() * 100) / 100;
    }
}
