<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Climate;

/**
 * Class Celsius.
 */
class Celsius extends Temperature
{
    /**
     * Convert to Celsius ValueObject type.
     * @psalm-suppress UnsafeInstantiation
     */
    public function toCelsius(): static
    {
        return new static($this->value);
    }

    /**
     * Convert to Kelvin ValueObject type.
     */
    public function toKelvin(): Kelvin
    {
        return new Kelvin($this->value + 273.15);
    }

    /**
     * Convert to Fahrenheit ValueObject type.
     */
    public function toFahrenheit(): Fahrenheit
    {
        return new Fahrenheit($this->value * 1.8 + 32);
    }
}
