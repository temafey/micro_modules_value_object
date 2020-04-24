<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Web;

use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Web\FragmentIdentifier;
use MicroModule\ValueObject\Web\NullFragmentIdentifier;

class FragmentIdentifierTest extends TestCase
{
    public function testValidFragmentIdentifier(): void
    {
        $fragment = new FragmentIdentifier('#id');

        $this->assertInstanceOf('MicroModule\ValueObject\Web\FragmentIdentifier', $fragment);
    }

    public function testNullFragmentIdentifier(): void
    {
        $fragment = new NullFragmentIdentifier();

        $this->assertInstanceOf('MicroModule\ValueObject\Web\FragmentIdentifier', $fragment);
    }

    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidFragmentIdentifier(): void
    {
        new FragmentIdentifier('invalìd');
    }
}
