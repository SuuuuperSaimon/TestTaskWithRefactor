<?php

namespace App\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use App\Service\CommissionCalculatorService;
use App\Service\BinProviderInterface;
use App\Service\ExchangeRateProviderInterface;
use App\Service\CountryValidatorInterface;
use App\DTO\Transaction;

class CommissionCalculatorServiceTest extends TestCase
{
    public function testCalculateCommission()
    {
        $binProvider = $this->createMock(BinProviderInterface::class);
        $exchangeProvider = $this->createMock(ExchangeRateProviderInterface::class);
        $countryValidator = $this->createMock(CountryValidatorInterface::class);

        $binProvider->method('getCountryCode')->willReturnMap([
            ['45717360', 'DK'],
            ['516793', 'US'],
        ]);
        $exchangeProvider->method('getRate')->willReturnMap([
            ['EUR', 1.0],
            ['USD', 1.1],
        ]);
        $countryValidator->method('isEu')->willReturnMap([
            ['DK', true],
            ['US', false],
        ]);

        $service = new CommissionCalculatorService(
            $binProvider,
            $exchangeProvider,
            $countryValidator
        );

        $transactionEu = new Transaction('45717360', 100.00, 'EUR');
        $transactionNonEu = new Transaction('516793', 50.00, 'USD');

        $this->assertEquals(1.0, $service->calculate($transactionEu));
        $this->assertEquals(0.91, $service->calculate($transactionNonEu));
    }
}

