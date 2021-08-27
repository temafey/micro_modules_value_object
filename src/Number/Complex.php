<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Number;

use MicroModule\ValueObject\ValueObjectInterface;
use BadMethodCallException;

/**
 * Class Complex.
 */
class Complex implements ValueObjectInterface, NumberInterface
{
    /**
     * Real ValueObject.
     */
    protected Real $real;

    /**
     * Real ValueObject.
     */
    protected Real $im;

    /**
     * Returns a new Complex object from native PHP arguments.
     */
    public static function fromNative(): static
    {
        $args = func_get_args();

        if (2 !== count($args)) {
            throw new BadMethodCallException('You must provide 2 arguments: 1) real part, 2) imaginary part');
        }

        $real = Real::fromNative($args[0]);
        $im = Real::fromNative($args[1]);

        /** @psalm-suppress ArgumentTypeCoercion */
        return new static($real, $im);
    }

    /**
     * Returns a Complex given polar coordinates.
     */
    public static function fromPolar(Real $modulus, Real $argument): static
    {
        $realValue = $modulus->toNative() * cos($argument->toNative());
        $imValue = $modulus->toNative() * sin($argument->toNative());
        $real = new Real($realValue);
        $im = new Real($imValue);

        return new static($real, $im);
    }

    /**
     * Returns a Complex object give its real and imaginary parts as parameters.
     */
    public function __construct(Real $real, Real $im)
    {
        $this->real = $real;
        $this->im = $im;
    }

    /**
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $complex): bool
    {
        if (!$complex instanceof static) {
            return false;
        }

        return $this->getReal()->sameValueAs($complex->getReal()) &&
            $this->getIm()->sameValueAs($complex->getIm());
    }

    /**
     * Returns the native value of the real and imaginary parts as an array.
     *
     * @return array<int,float>
     */
    public function toNative(): array
    {
        return [
            $this->getReal()->toNative(),
            $this->getIm()->toNative(),
        ];
    }

    /**
     * Returns the real part of the complex number.
     */
    public function getReal(): Real
    {
        return clone $this->real;
    }

    /**
     * Returns the imaginary part of the complex number.
     */
    public function getIm(): Real
    {
        return clone $this->im;
    }

    /**
     * Returns the modulus (or absolute value or magnitude) of the Complex number.
     */
    public function getModulus(): Real
    {
        $real = $this->getReal()->toNative();
        $im = $this->getIm()->toNative();
        $mod = sqrt(($real ** 2) + ($im ** 2));

        return new Real($mod);
    }

    /**
     * Returns the argument (or phase) of the Complex number.
     */
    public function getArgument(): Real
    {
        $real = $this->getReal()->toNative();
        $im = $this->getIm()->toNative();
        $arg = atan2($im, $real);

        return new Real($arg);
    }

    /**
     * Returns a native string version of the Complex object in format "${real} +|- ${complex}i".
     */
    public function __toString(): string
    {
        $format = '%g %+gi';
        $real = $this->getReal()->toNative();
        $im = $this->getIm()->toNative();
        $string = sprintf($format, $real, $im);
        $string = preg_replace('/([+\-])/', '$1 ', $string);

        return (string)$string;
    }
}
