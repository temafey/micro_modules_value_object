<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Web;

use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Web\Hostname;

class HostnameTest extends TestCase
{
    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidHostname(): void
    {
        new Hostname('inv@lìd');
    }
}
