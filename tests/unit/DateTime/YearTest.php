<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\DateTime;

use MicroModule\ValueObject\DateTime\Year;
use MicroModule\ValueObject\Tests\Unit\TestCase;

class YearTest extends TestCase
{
    public function testNow(): void
    {
        $year = Year::now();
        $this->assertEquals(date('Y'), $year->toNative());
    }
}
