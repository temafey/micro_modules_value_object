<?php

declare(strict_types=1);

namespace MicroModule\ValueObject;

/**
 * Interface ValueObjectInterface.
 */
interface ValueObjectInterface
{
    /**
     * Returns a object taking PHP native value(s) as argument(s).
     */
    public static function fromNative(): static;

    /**
     * Return native value.
     *
     * @return mixed
     */
    public function toNative();

    /**
     * Compare two ValueObjectInterface and tells whether they can be considered equal.
     */
    public function sameValueAs(self $valueObject): bool;

    /**
     * Returns a string representation of the object.
     */
    public function __toString(): string;
}
