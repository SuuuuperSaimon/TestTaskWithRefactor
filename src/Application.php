<?php

namespace App;

use App\Service\CommissionCalculatorInterface;
use App\Service\TransactionReaderInterface;

class Application
{
    public function __construct(
        private TransactionReaderInterface $transactionReader,
        private CommissionCalculatorInterface $commissionCalculator
    ) {}

    public function process(string $inputFile): void
    {
        foreach ($this->transactionReader->read($inputFile) as $transaction) {
            try {
                $commission = $this->commissionCalculator->calculate($transaction);
                echo $commission . PHP_EOL;
            } catch (\Throwable $e) {
                fwrite(
                    STDERR,
                    "Error processing transaction with BIN {$transaction->bin}: {$e->getMessage()}" . PHP_EOL
                );
            }
        }
    }
}
