<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Geography;

use MicroModule\ValueObject\Geography\Country;
use MicroModule\ValueObject\Geography\CountryCode;
use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\ValueObjectInterface;

class CountryTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeCountry = Country::fromNative('IT');
        $constructedCountry = new Country(CountryCode::IT());

        $this->assertTrue($constructedCountry->sameValueAs($fromNativeCountry));
    }

    public function testSameValueAs(): void
    {
        $country1 = new Country(CountryCode::IT());
        $country2 = new Country(CountryCode::IT());
        $country3 = new Country(CountryCode::US());

        $this->assertTrue($country1->sameValueAs($country2));
        $this->assertTrue($country2->sameValueAs($country1));
        $this->assertFalse($country1->sameValueAs($country3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($country1->sameValueAs($mock));
    }

    public function testGetCode(): void
    {
        $italy = new Country(CountryCode::IT());
        $this->assertTrue($italy->getCode()->sameValueAs(CountryCode::IT()));
    }

    public function testGetName(): void
    {
        $italy = new Country(CountryCode::IT());
        $name = new StringLiteral('Italy');
        $this->assertTrue($italy->getName()->sameValueAs($name));
    }

    public function testToString(): void
    {
        $italy = new Country(CountryCode::IT());
        $this->assertSame('Italy', $italy->__toString());
    }
}
