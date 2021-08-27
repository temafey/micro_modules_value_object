<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\StringLiteral;

use MicroModule\ValueObject\ValueObjectInterface;

/**
 * Class StringLiteral.
 */
class StringLiteral implements ValueObjectInterface
{
    /**
     * String native value.
     *
     * @var string
     */
    protected $value;

    /**
     * Returns a StringLiteral object given a PHP native string as parameter.
     */
    public static function fromNative(): static
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns a StringLiteral object given a PHP native string as parameter.
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Returns the value of the string.
     */
    public function toNative(): string
    {
        return $this->value;
    }

    /**
     * Tells whether two string literals are equal by comparing their values.
     */
    public function sameValueAs(ValueObjectInterface $stringLiteral): bool
    {
        if (!$stringLiteral instanceof static) {
            return false;
        }

        return $this->toNative() === $stringLiteral->toNative();
    }

    /**
     * Tells whether the StringLiteral is empty.
     */
    public function isEmpty(): bool
    {
        return '' === $this->toNative();
    }

    /**
     * Returns the string value itself.
     */
    public function __toString(): string
    {
        return $this->toNative();
    }
}
