<?php

namespace App\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use App\Service\BinListProvider;
use App\Service\HttpClientInterface;

class BinListProviderTest extends TestCase
{
    public function testGetCountryCodeReturnsCorrectCode()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $bin = '45717360';

        $httpClient->method('get')
            ->with("https://lookup.binlist.net/$bin")
            ->willReturn(json_encode(['country' => ['alpha2' => 'DK']]));

        $provider = new BinListProvider($httpClient);

        $this->assertSame('DK', $provider->getCountryCode($bin));
    }

    public function testGetCountryCodeThrowsExceptionIfNotFound()
    {
        $this->expectException(\RuntimeException::class);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $bin = '00000000';

        $httpClient->method('get')
            ->with("https://lookup.binlist.net/$bin")
            ->willReturn(json_encode(['country' => []]));

        $provider = new BinListProvider($httpClient);
        $provider->getCountryCode($bin);
    }
}
