<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Number;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\Number\Integer as IntegerValueObject;
use MicroModule\ValueObject\ValueObjectInterface;

/**
 * Class Real.
 */
class Real implements ValueObjectInterface, NumberInterface
{
    /**
     * Real number value
     *
     * @psalm-consistent-constructor
     */
    protected float $value;

    /**
     * Returns a Real object given a PHP native float as parameter.
     */
    public static function fromNative(): static
    {
        $value = func_get_arg(0);
        $value = filter_var($value, FILTER_VALIDATE_FLOAT);
        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['float']);
        }

        return new static($value);
    }

    /**
     * Returns a Real object given a PHP native float as parameter.
     */
    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * Returns the native value of the real number.
     */
    public function toNative(): float
    {
        return $this->value;
    }

    /**
     * Tells whether two Real are equal by comparing their values.
     */
    public function sameValueAs(ValueObjectInterface $real): bool
    {
        if (!$real instanceof static) {
            return false;
        }

        return $this->toNative() === $real->toNative();
    }

    /**
     * Returns the integer part of the Real number as a Integer.
     *
     * @param null|RoundingMode $roundingMode Rounding mode of the conversion. Defaults to RoundingMode::HALF_UP.
     */
    public function toInteger(?RoundingMode $roundingMode = null): IntegerValueObject
    {
        if (null === $roundingMode) {
            $roundingMode = RoundingMode::HALF_UP();
        }

        $value = $this->toNative();
        $integerValue = (int)(round($value, 0, $roundingMode->toNative()));

        return new Integer($integerValue);
    }

    /**
     * Returns the absolute integer part of the Real number as a Natural.
     *
     * @param null|RoundingMode $roundingMode Rounding mode of the conversion. Defaults to RoundingMode::HALF_UP.
     */
    public function toNatural(?RoundingMode $roundingMode = null): Natural
    {
        $integerValue = $this->toInteger($roundingMode)->toNative();
        $naturalValue = abs($integerValue);

        return new Natural($naturalValue);
    }

    /**
     * Returns the string representation of the real value.
     */
    public function __toString(): string
    {
        return (string)$this->toNative();
    }
}
