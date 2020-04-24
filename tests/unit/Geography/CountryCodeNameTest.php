<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Geography;

use MicroModule\ValueObject\Geography\CountryCode;
use MicroModule\ValueObject\Geography\CountryCodeName;
use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\Tests\Unit\TestCase;

class CountryCodeNameTest extends TestCase
{
    public function testGetName(): void
    {
        $code = CountryCode::IT();
        $name = CountryCodeName::getName($code);
        $expectedString = new StringLiteral('Italy');

        $this->assertTrue($name->sameValueAs($expectedString));
    }
}
