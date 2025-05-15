<?php

namespace App\Service;

interface HttpClientInterface
{
    public function get(string $url): string;
}
