<?php

namespace App\Enum;

enum CommissionRateEnum
{
    case EU;
    case NON_EU;

    public function rate(): float
    {
        return match($this) {
            self::EU => 0.01,
            self::NON_EU => 0.02,
        };
    }
}
