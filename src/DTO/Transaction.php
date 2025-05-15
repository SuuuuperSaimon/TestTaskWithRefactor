<?php

namespace App\DTO;

class Transaction
{
    public function __construct(
        public readonly string $bin,
        public readonly float $amount,
        public readonly string $currency
    ) {}

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true, flags: JSON_THROW_ON_ERROR);
        return new self($data['bin'], (float)$data['amount'], $data['currency']);
    }
}
