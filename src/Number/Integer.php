<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Number;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\ValueObjectInterface;

/**
 * Class Integer.
 */
class Integer implements ValueObjectInterface, NumberInterface
{
    protected int $value;

    /**
     * Returns a Integer object given a PHP native int as parameter.
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * Tells whether two Integer are equal by comparing their values.
     */
    public function sameValueAs(ValueObjectInterface $integer): bool
    {
        if (!$integer instanceof static) {
            return false;
        }

        return $this->toNative() === $integer->toNative();
    }

    /**
     * Returns the value of the integer number.
     */
    public function toNative(): int
    {
        return $this->value;
    }

    /**
     * Returns a Real with the value of the Integer.
     */
    public function toReal(): Real
    {
        $value = (float)$this->toNative();

        return new Real($value);
    }

    /**
     * Increment value.
     */
    public function inc(): static
    {
        ++$this->value;

        return $this;
    }

    /**
     * Decrement value.
     */
    public function decr(): static
    {
        --$this->value;

        return $this;
    }

    public static function fromNative(): static
    {
        $value = func_get_arg(0);
        $value = filter_var($value, FILTER_VALIDATE_INT);
        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['int']);
        }

        return new static($value);
    }

    /**
     * Returns a string representation of the integer value.
     */
    public function __toString(): string
    {
        return (string)$this->toNative();
    }
}
