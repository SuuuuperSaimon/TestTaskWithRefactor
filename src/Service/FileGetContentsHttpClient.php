<?php

namespace App\Service;

class FileGetContentsHttpClient implements HttpClientInterface
{
    public function get(string $url): string
    {
        $result = file_get_contents($url);

        if ($result === false) {
            throw new \RuntimeException("Failed to fetch URL: $url");
        }

        return $result;
    }
}
