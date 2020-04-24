<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Web;

use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Web\SchemeName;

class SchemeNameTest extends TestCase
{
    public function testValidSchemeName(): void
    {
        $scheme = new SchemeName('git+ssh');
        $this->assertInstanceOf('MicroModule\ValueObject\Web\SchemeName', $scheme);
    }

    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidSchemeName(): void
    {
        new SchemeName('ht*tp');
    }
}
