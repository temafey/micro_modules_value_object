<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Geography;

use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\ValueObjectInterface;
use BadMethodCallException;

/**
 * Class Street.
 */
class Street implements ValueObjectInterface
{
    /**
     * Street name ValueObject.
     */
    protected StringLiteral $name;

    /**
     * Street number ValueObject.
     */
    protected StringLiteral $number;

    /**
     *  Street Building, floor and unit ValueObject.
     */
    protected StringLiteral $elements;

    /**
     * Use properties corresponding placeholders: %name%, %number%, %elements%.
     */
    protected StringLiteral $format;

    /**
     * Returns a new Street from native PHP string name and number.
     */
    public static function fromNative(): static
    {
        $args = func_get_args();

        if (count($args) < 2) {
            throw new BadMethodCallException(
                'You must provide from 2 to 4 arguments: 1) street name, 2) street number, 3) elements, 4) format (optional)'
            );
        }

        $nameString = $args[0];
        $numberString = $args[1];
        $elementsString = $args[2] ?? null;
        $formatString = $args[3] ?? null;

        $name = new StringLiteral($nameString);
        $number = new StringLiteral($numberString);
        $elements = $elementsString ? new StringLiteral($elementsString) : null;
        $format = $formatString ? new StringLiteral($formatString) : null;

        return new static($name, $number, $elements, $format);
    }

    /**
     * Returns a new Street object.
     */
    public function __construct(
        StringLiteral $name,
        StringLiteral $number,
        ?StringLiteral $elements = null,
        ?StringLiteral $format = null
    ) {
        $this->name = $name;
        $this->number = $number;

        if (null === $elements) {
            $elements = new StringLiteral('');
        }
        $this->elements = $elements;

        if (null === $format) {
            $format = new StringLiteral('%number% %name%');
        }
        $this->format = $format;
    }

    /**
     * Return native value.
     */
    public function toNative(): string
    {
        return $this->__toString();
    }

    /**
     * Tells whether two Street objects are equal.
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $street): bool
    {
        if (!$street instanceof static) {
            return false;
        }

        return $this->getName()->sameValueAs($street->getName()) &&
            $this->getNumber()->sameValueAs($street->getNumber()) &&
            $this->getElements()->sameValueAs($street->getElements());
    }

    /**
     * Returns street name.
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }

    /**
     * Returns street number.
     */
    public function getNumber(): StringLiteral
    {
        return clone $this->number;
    }

    /**
     * Returns street elements.
     */
    public function getElements(): StringLiteral
    {
        return clone $this->elements;
    }

    /**
     * Returns a string representation of the StringLiteral in the format defined in the constructor.
     */
    public function __toString(): string
    {
        $replacements = [
            '%name%' => $this->getName()->toNative(),
            '%number%' => $this->getNumber()->toNative(),
            '%elements%' => $this->getElements()->toNative(),
        ];

        return str_replace(array_keys($replacements), $replacements, $this->format->toNative());
    }
}
