<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Tests\Unit\Web;

use MicroModule\ValueObject\Structure\Dictionary;
use MicroModule\ValueObject\Tests\Unit\TestCase;
use MicroModule\ValueObject\Web\NullQueryString;
use MicroModule\ValueObject\Web\QueryString;

class QueryStringTest extends TestCase
{
    public function testValidQueryString(): void
    {
        $query = new QueryString('?foo=bar');

        $this->assertInstanceOf('MicroModule\ValueObject\Web\QueryString', $query);
    }

    public function testEmptyQueryString(): void
    {
        $query = new NullQueryString();

        $this->assertInstanceOf('MicroModule\ValueObject\Web\QueryString', $query);

        $dictionary = $query->toDictionary();
        $this->assertInstanceOf('MicroModule\ValueObject\Structure\Dictionary', $dictionary);
    }

    /** @expectedException MicroModule\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidQueryString(): void
    {
        new QueryString('invalìd');
    }

    public function testToDictionary(): void
    {
        $query = new QueryString('?foo=bar&array[]=one&array[]=two');
        $dictionary = $query->toDictionary();

        $this->assertInstanceOf('MicroModule\ValueObject\Structure\Dictionary', $dictionary);

        $array = [
            'foo' => 'bar',
            'array' => [
                'one',
                'two',
            ],
        ];
        $expectedDictionary = Dictionary::fromNative($array);

        $this->assertTrue($expectedDictionary->sameValueAs($dictionary));
    }
}
