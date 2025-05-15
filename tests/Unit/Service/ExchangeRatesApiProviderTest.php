<?php

namespace App\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use App\Service\ExchangeRatesApiProvider;
use App\Service\HttpClientInterface;

class ExchangeRatesApiProviderTest extends TestCase
{
    public function testGetRateReturnsCorrectValue()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('get')
            ->with("https://api.exchangerate.host/latest")
            ->willReturn(json_encode(['rates' => ['USD' => 1.1, 'EUR' => 1.0]]));

        $provider = new ExchangeRatesApiProvider($httpClient);

        $this->assertSame(1.1, $provider->getRate('USD'));
        $this->assertSame(1.0, $provider->getRate('EUR'));
    }

    public function testGetRateReturnsZeroIfCurrencyNotFound()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('get')
            ->willReturn(json_encode(['rates' => ['USD' => 1.1]]));

        $provider = new ExchangeRatesApiProvider($httpClient);

        $this->assertSame(0.0, $provider->getRate('JPY'));
    }
}

