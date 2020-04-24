<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Web;

use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Web\Domain;

class DomainTest extends TestCase
{
    public function testSpecifyType(): void
    {
        $ip = Domain::specifyType('127.0.0.1');
        $hostname = Domain::specifyType('example.com');

        $this->assertInstanceOf('MicroModule\ValueObject\Web\IPAddress', $ip);
        $this->assertInstanceOf('MicroModule\ValueObject\Web\Hostname', $hostname);
    }
}
