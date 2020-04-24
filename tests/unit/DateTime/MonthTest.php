<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\DateTime;

use MicroModule\ValueObject\DateTime\Month;
use MicroModule\ValueObject\Tests\Unit\TestCase;

class MonthTest extends TestCase
{
    public function testNow(): void
    {
        $month = Month::now();
        $this->assertEquals(date('F'), $month->toNative());
    }

    public function testFromNativeDateTime(): void
    {
        $nativeDateTime = new \DateTime();
        $nativeDateTime->setDate(2013, 12, 1);

        $month = Month::fromNativeDateTime($nativeDateTime);

        $this->assertEquals('December', $month->toNative());
    }

    public function testGetNumericValue(): void
    {
        $month = Month::APRIL();

        $this->assertEquals(4, $month->getNumericValue());
    }
}
