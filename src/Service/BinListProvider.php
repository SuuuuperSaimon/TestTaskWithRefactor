<?php

namespace App\Service;

class BinListProvider implements BinProviderInterface
{
    public function __construct(private HttpClientInterface $httpClient) {}

    public function getCountryCode(string $bin): string
    {
        $data = json_decode($this->httpClient->get("https://lookup.binlist.net/$bin"), true);

        if (empty($data['country']['alpha2'])) {
            throw new \RuntimeException("Country code not found for BIN $bin");
        }

        return $data['country']['alpha2'];
    }
}
