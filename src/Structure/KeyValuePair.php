<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Structure;

use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\ValueObjectInterface;
use BadMethodCallException;

/**
 * Class KeyValuePair.
 */
class KeyValuePair implements ValueObjectInterface
{
    /**
     * Key ValueObjectInterface.
     */
    protected ValueObjectInterface $key;

    /**
     * Value ValueObjectInterface.
     */
    protected ValueObjectInterface $value;

    /**
     * Returns a KeyValuePair from native PHP arguments evaluated as strings.
     */
    public static function fromNative(): static
    {
        $args = func_get_args();

        if (2 !== count($args)) {
            throw new BadMethodCallException(
                'This methods expects two arguments. One for the key and one for the value.'
            );
        }
        $keyString = (string)$args[0];
        $valueString = (string)$args[1];
        $key = new StringLiteral($keyString);
        $value = new StringLiteral($valueString);

        return new static($key, $value);
    }

    /**
     * Returns a KeyValuePair.
     */
    public function __construct(ValueObjectInterface $key, ValueObjectInterface $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Return native value.
     */
    public function toNative(): string
    {
        return $this->__toString();
    }

    /**
     * Tells whether two KeyValuePair are equal.
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $keyValuePair): bool
    {
        if (!$keyValuePair instanceof static) {
            return false;
        }

        return $this->getKey()->sameValueAs($keyValuePair->getKey()) && $this->getValue()->sameValueAs(
                $keyValuePair->getValue()
            );
    }

    /**
     * Returns key.
     */
    public function getKey(): ValueObjectInterface
    {
        return clone $this->key;
    }

    /**
     * Returns value.
     */
    public function getValue(): ValueObjectInterface
    {
        return clone $this->value;
    }

    /**
     * Returns a string representation of the KeyValuePair in format "$key => $value".
     */
    public function __toString(): string
    {
        return serialize($this->toArray());
    }

    /**
     * Return array of key and value.
     *
     * @return array<string>
     */
    public function toArray(): array
    {
        return [$this->getKey()->toNative(), $this->getValue()->toNative()];
    }
}
