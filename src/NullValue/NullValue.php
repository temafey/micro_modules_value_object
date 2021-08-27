<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\NullValue;

use MicroModule\ValueObject\Util\Util;
use MicroModule\ValueObject\ValueObjectInterface;
use BadMethodCallException;

/**
 * Class NullValue.
 */
class NullValue implements ValueObjectInterface
{
    /**
     * @throws BadMethodCallException
     */
    public static function fromNative(): static
    {
        throw new BadMethodCallException('Cannot create a NullValue object via this method.');
    }

    /**
     * Return native value.
     *
     * @return null
     */
    public function toNative()
    {
        return null;
    }

    /**
     * Returns a new NullValue object.
     */
    public static function create(): static
    {
        return new static();
    }

    /**
     * Tells whether two objects are both NullValue.
     */
    public function sameValueAs(ValueObjectInterface $null): bool
    {
        return Util::classEquals($this, $null);
    }

    /**
     * Returns a string representation of the NullValue object.
     */
    public function __toString(): string
    {
        return '';
    }
}
