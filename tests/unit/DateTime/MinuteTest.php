<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\DateTime;

use MicroModule\ValueObject\DateTime\Minute;
use MicroModule\ValueObject\Tests\Unit\TestCase;

class MinuteTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeMinute = Minute::fromNative(11);
        $constructedMinute = new Minute(11);

        $this->assertTrue($fromNativeMinute->sameValueAs($constructedMinute));
    }

    public function testNow(): void
    {
        $minute = Minute::now();
        $this->assertEquals(intval(date('i')), $minute->toNative());
    }

    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidMinute(): void
    {
        new Minute(60);
    }
}
