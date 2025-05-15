<?php

namespace App\Service;

class ExchangeRatesApiProvider implements ExchangeRateProviderInterface
{
    private array $rates;

    public function __construct(private HttpClientInterface $httpClient)
    {
        $data = json_decode($this->httpClient->get("https://api.exchangerate.host/latest"), true);
        $this->rates = $data['rates'] ?? [];
    }

    public function getRate(string $currency): float
    {
        return $this->rates[$currency] ?? 0.0;
    }
}
