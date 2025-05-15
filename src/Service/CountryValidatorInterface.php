<?php

namespace App\Service;

interface CountryValidatorInterface
{
    public function isEu(string $countryCode): bool;
}
