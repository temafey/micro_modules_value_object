<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Web;

use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Web\IPv6Address;

class IPv6AddressTest extends TestCase
{
    public function testValidIPv6Address(): void
    {
        $ip = new IPv6Address('::1');

        $this->assertInstanceOf('MicroModule\ValueObject\Web\IPv6Address', $ip);
    }

    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidIPv6Address(): void
    {
        new IPv6Address('127.0.0.1');
    }
}
