<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Web;

use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Web\EmailAddress;

class EmailAddressTest extends TestCase
{
    public function testValidEmailAddress(): void
    {
        $email1 = new EmailAddress('foo@bar.com');
        $this->assertInstanceOf('MicroModule\ValueObject\Web\EmailAddress', $email1);

        $email2 = new EmailAddress('foo@[120.0.0.1]');
        $this->assertInstanceOf('MicroModule\ValueObject\Web\EmailAddress', $email2);
    }

    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidEmailAddress(): void
    {
        new EmailAddress('invalid');
    }

    public function testGetLocalPart(): void
    {
        $email = new EmailAddress('foo@bar.baz');
        $localPart = $email->getLocalPart();

        $this->assertEquals('foo', $localPart->toNative());
    }

    public function testGetDomainPart(): void
    {
        $email = new EmailAddress('foo@bar.com');
        $domainPart = $email->getDomainPart();

        $this->assertEquals('bar.com', $domainPart->toNative());
        $this->assertInstanceOf('MicroModule\ValueObject\Web\Domain', $domainPart);
    }
}
