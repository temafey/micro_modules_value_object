<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Climate;

/**
 * Class Kelvin.
 */
class Kelvin extends Temperature
{
    /**
     * Convert to Celsius ValueObject type.
     */
    public function toCelsius(): Celsius
    {
        return new Celsius($this->value - 273.15);
    }

    /**
     * Convert to Kelvin ValueObject type.
     */
    public function toKelvin(): static
    {
        return new static($this->value);
    }

    /**
     * Convert to Fahrenheit ValueObject type.
     */
    public function toFahrenheit(): Fahrenheit
    {
        return new Fahrenheit($this->toCelsius()->toNative() * 1.8 + 32);
    }
}
