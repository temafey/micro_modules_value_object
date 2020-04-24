<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Web;

use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Web\IPv4Address;

class IPv4AddressTest extends TestCase
{
    public function testValidIPv4Address(): void
    {
        $ip = new IPv4Address('127.0.0.1');

        $this->assertInstanceOf('MicroModule\ValueObject\Web\IPv4Address', $ip);
    }

    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidIPv4Address(): void
    {
        new IPv4Address('::1');
    }
}
