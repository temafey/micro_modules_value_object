<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Person;

use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\ValueObjectInterface;
use Exception;

/**
 * Class Name.
 */
class Name implements ValueObjectInterface
{
    /**
     * First name ValueObject.
     */
    private StringLiteral $firstName;

    /**
     * Middle name ValueObject.
     */
    private StringLiteral $middleName;

    /**
     * Last name ValueObject.
     */
    private StringLiteral $lastName;

    /**
     * Returns a Name objects form PHP native values.
     */
    public static function fromNative(): static
    {
        $args = func_get_args();

        $firstName = new StringLiteral($args[0]);
        $middleName = new StringLiteral($args[1]);
        $lastName = new StringLiteral($args[2]);

        return new static($firstName, $middleName, $lastName);
    }

    /**
     * Returns a Name object.
     */
    public function __construct(StringLiteral $firstName, StringLiteral $middleName, StringLiteral $lastName)
    {
        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->lastName = $lastName;
    }

    /**
     * Return native value.
     */
    public function toNative(): string
    {
        return $this->__toString();
    }

    /**
     * Returns the first name.
     */
    public function getFirstName(): StringLiteral
    {
        return $this->firstName;
    }

    /**
     * Returns the middle name.
     */
    public function getMiddleName(): StringLiteral
    {
        return $this->middleName;
    }

    /**
     * Returns the last name.
     */
    public function getLastName(): StringLiteral
    {
        return $this->lastName;
    }

    /**
     * Returns the full name.
     */
    public function getFullName(): StringLiteral
    {
        $fullNameString = $this->firstName .
            ($this->middleName->isEmpty() ? '' : ' ' . $this->middleName) .
            ($this->lastName->isEmpty() ? '' : ' ' . $this->lastName);

        return new StringLiteral($fullNameString);
    }

    /**
     * Tells whether two names are equal by comparing their values.
     *
     * @psalm-suppress UndefinedInterfaceMethod|Exception
     */
    public function sameValueAs(ValueObjectInterface $name): bool
    {
        if (!$name instanceof static) {
            return false;
        }

        return $this->getFullName()->toNative() === $name->getFullName()->toNative();
    }

    /**
     * Returns the full name.
     */
    public function __toString(): string
    {
        return (string)$this->getFullName();
    }
}
