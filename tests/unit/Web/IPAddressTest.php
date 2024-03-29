<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Web;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Web\IPAddress;
use MicroModule\ValueObject\Web\IPAddressVersion;

class IPAddressTest extends TestCase
{
    public function testGetVersion(): void
    {
        $ip4 = new IPAddress('127.0.0.1');
        $this->assertSame(IPAddressVersion::IPV4, $ip4->getVersion()->getValue());

        $ip6 = new IPAddress('::1');
        $this->assertSame(IPAddressVersion::IPV6, $ip6->getVersion()->getValue());
    }

    public function testInvalidIPAddress(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new IPAddress('invalid');
    }
}
