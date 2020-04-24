<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Climate;

use MicroModule\ValueObject\Climate\RelativeHumidity;
use MicroModule\ValueObject\Tests\Unit\TestCase;

class RelativeHumidityTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeRelHum = RelativeHumidity::fromNative(70);
        $constructedRelHum = new RelativeHumidity(70);

        $this->assertTrue($fromNativeRelHum->sameValueAs($constructedRelHum));
    }

    /**
     * @expectedException \MicroModule\ValueObject\Exception\InvalidNativeArgumentException
     */
    public function testInvalidRelativeHumidity(): void
    {
        new RelativeHumidity(128);
    }
}
