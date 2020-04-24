<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Web;

use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Web\PortNumber;

class PortNumberTest extends TestCase
{
    public function testValidPortNumber(): void
    {
        $port = new PortNumber(80);

        $this->assertInstanceOf('MicroModule\ValueObject\Web\PortNumber', $port);
    }

    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidPortNumber(): void
    {
        new PortNumber(65536);
    }
}
