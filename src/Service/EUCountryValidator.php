<?php

namespace App\Service;

use App\Enum\EUCountriesEnum;

class EUCountryValidator implements CountryValidatorInterface
{
    public function isEu(string $countryCode): bool
    {
        return EUCountriesEnum::tryFrom($countryCode) !== null;
    }
}
