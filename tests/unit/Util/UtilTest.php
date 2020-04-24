<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Util;

use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Util\Util;

class UtilTest extends TestCase
{
    public function testClassEquals(): void
    {
        $util1 = new Util();
        $util2 = new Util();

        $this->assertTrue(Util::classEquals($util1, $util2));
        $this->assertFalse(Util::classEquals($util1, $this));
    }

    public function testGetClassAsString(): void
    {
        $util = new Util();
        $this->assertEquals('MicroModule\ValueObject\Util\Util', Util::getClassAsString($util));
    }
}
