<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Geography;

use MicroModule\ValueObject\Geography\Latitude;
use MicroModule\ValueObject\Tests\Unit\TestCase;

class LatitudeTest extends TestCase
{
    public function testValidLatitude(): void
    {
        new Latitude(40.829137);
    }

    public function testNormalization(): void
    {
        $latitude = new Latitude(91);
        $this->assertEquals(90, $latitude->toNative());
    }

    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidLatitude(): void
    {
        new Latitude('invalid');
    }
}
