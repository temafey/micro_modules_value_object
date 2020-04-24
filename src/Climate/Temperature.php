<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Climate;

use MicroModule\ValueObject\Number\Real;

/**
 * Class Temperature.
 */
abstract class Temperature extends Real
{
    /**
     * Convert to Celsius ValueObject type.
     *
     * @return Celsius
     */
    abstract public function toCelsius(): Celsius;

    /**
     * Convert to Kelvin ValueObject type.
     *
     * @return Kelvin
     */
    abstract public function toKelvin(): Kelvin;

    /**
     * Convert to Fahrenheit ValueObject type.
     *
     * @return Fahrenheit
     */
    abstract public function toFahrenheit(): Fahrenheit;
}
