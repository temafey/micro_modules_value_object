<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Logical;

use MicroModule\ValueObject\ValueObjectInterface;

/**
 * Class Boolean.
 */
class Boolean implements ValueObjectInterface
{
    /**
     * Bool value.
     */
    protected bool $value;

    /**
     * Returns a Boolean object given a PHP native string as parameter.
     */
    public static function fromNative(): static
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Boolean constructor.
     */
    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    /**
     * Returns the value of the bool.
     */
    public function toNative(): bool
    {
        return $this->value;
    }

    /**
     * Tells whether two boolean are equal by comparing their values.
     */
    public function sameValueAs(ValueObjectInterface $bool): bool
    {
        if (!$bool instanceof static) {
            return false;
        }

        return $this->toNative() === $bool->toNative();
    }

    /**
     * Returns the string value itself.
     */
    public function __toString(): string
    {
        return true === $this->toNative() ? 'true' : 'false';
    }
}
