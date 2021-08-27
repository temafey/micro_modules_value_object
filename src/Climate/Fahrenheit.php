<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Climate;

/**
 * Class Fahrenheit.
 */
class Fahrenheit extends Temperature
{
    /**
     * Convert to Celsius ValueObject type.
     */
    public function toCelsius(): Celsius
    {
        return new Celsius(($this->value - 32) / 1.8);
    }

    /**
     * Convert to Kelvin ValueObject type.
     */
    public function toKelvin(): Kelvin
    {
        return new Kelvin($this->toCelsius()->toNative() + 273.15);
    }

    /**
     * Convert to Fahrenheit ValueObject type.
     */
    public function toFahrenheit(): static
    {
        return new static($this->value);
    }
}
