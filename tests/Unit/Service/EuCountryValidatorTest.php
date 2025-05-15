<?php

namespace App\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use App\Service\EuCountryValidator;

class EuCountryValidatorTest extends TestCase
{
    public function testIsEu()
    {
        $validator = new EuCountryValidator();

        $this->assertTrue($validator->isEu('LT'));
        $this->assertTrue($validator->isEu('DE'));
        $this->assertFalse($validator->isEu('US'));
        $this->assertFalse($validator->isEu('RU'));
    }
}
