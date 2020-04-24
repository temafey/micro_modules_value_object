<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Web;

use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Web\Path;

class PathTest extends TestCase
{
    public function testValidPath(): void
    {
        $pathString = '/path/to/resource.ext';
        $path = new Path($pathString);
        $this->assertEquals($pathString, $path->toNative());
    }

    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidPath(): void
    {
        new Path('//valid?');
    }
}
