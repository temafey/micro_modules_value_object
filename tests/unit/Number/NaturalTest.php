<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Number;

use MicroModule\ValueObject\Number\Natural;
use MicroModule\ValueObject\Tests\Unit\TestCase;

class NaturalTest extends TestCase
{
    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidNativeArgument(): void
    {
        new Natural(-2);
    }
}
