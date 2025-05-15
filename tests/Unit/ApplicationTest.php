<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Application;
use App\DTO\Transaction;
use App\Service\TransactionReaderInterface;
use App\Service\CommissionCalculatorInterface;

class ApplicationTest extends TestCase
{
    public function testCommissionCalculation()
    {
        $transactions = [
            new Transaction('45717360', 100.00, 'EUR'), // OK
            new Transaction('516793', 50.00, 'USD'),    // OK
        ];

        $transactionReader = $this->createMock(TransactionReaderInterface::class);
        $commissionCalculator = $this->createMock(CommissionCalculatorInterface::class);

        $transactionReader->method('read')->willReturn($transactions);
        $commissionCalculator->method('calculate')->willReturnMap([
            [$transactions[0], 1.0],
            [$transactions[1], 0.91],
        ]);

        ob_start();

        $app = new Application($transactionReader, $commissionCalculator);
        $app->process('dummy.txt');
        $output = ob_get_clean();

        $lines = array_values(array_filter(explode(PHP_EOL, $output)));

        $this->assertEquals('1', $lines[0]);
        $this->assertEquals('0.91', $lines[1]);
    }

    public function testProcessHandlesExceptionsAndContinues()
    {
        $transactions = [
            new Transaction('45717360', 100.00, 'EUR'),
            new Transaction('41417360', 200.00, 'EUR'),
            new Transaction('516793', 50.00, 'USD'),
        ];

        $transactionReader = $this->createMock(TransactionReaderInterface::class);
        $commissionCalculator = $this->createMock(CommissionCalculatorInterface::class);

        $transactionReader->method('read')->willReturn($transactions);

        $commissionCalculator->method('calculate')
            ->willReturnCallback(function (Transaction $transaction) {
                return match ([$transaction->bin, (string)$transaction->amount]) {
                    ['45717360', '100'] => 1.0,
                    ['516793', '50'] => 0.91,
                    default => throw new \RuntimeException('Country code not found for BIN ' . $transaction->bin)
                };
            });

        ob_start();

        (new Application($transactionReader, $commissionCalculator))->process('dummy.txt');

        $output = ob_get_clean();

        $this->assertEquals("1\n0.91\n", $output);
    }
}
