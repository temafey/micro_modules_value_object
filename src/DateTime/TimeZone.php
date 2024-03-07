<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\DateTime;

use MicroModule\ValueObject\DateTime\Exception\InvalidTimeZoneException;
use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\ValueObjectInterface;
use DateTimeZone;

class TimeZone implements ValueObjectInterface
{
    /**
     * Hour ValueObject.
     */
    protected StringLiteral $name;

    /**
     * Returns a new Time object from native timezone name.
     *
     * @throws InvalidTimeZoneException
     */
    public static function fromNative(): static
    {
        $args = func_get_args();
        $name = new StringLiteral($args[0]);

        return new static($name);
    }

    /**
     * Returns a new Time from a native PHP DateTime.
     *
     * @throws InvalidTimeZoneException
     */
    public static function fromNativeDateTimeZone(DateTimeZone $timezone): self
    {
        return static::fromNative($timezone->getName());
    }

    /**
     * Returns default TimeZone.
     *
     * @throws InvalidTimeZoneException
     */
    public static function fromDefault(): self
    {
        return new static(new StringLiteral(date_default_timezone_get()));
    }

    /**
     * Returns a new TimeZone object.
     *
     * @throws InvalidTimeZoneException
     */
    public function __construct(StringLiteral $name)
    {
        if (!in_array($name->toNative(), timezone_identifiers_list(), true)) {
            throw new InvalidTimeZoneException($name);
        }

        $this->name = $name;
    }

    /**
     * Return native value.
     */
    public function toNative(): DateTimeZone
    {
        return $this->toNativeDateTimeZone();
    }

    /**
     * Returns a native PHP DateTimeZone version of the current TimeZone.
     */
    public function toNativeDateTimeZone(): DateTimeZone
    {
        return new DateTimeZone($this->getName()->toNative());
    }

    /**
     * Tells whether two DateTimeZone are equal by comparing their names.
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $timezone): bool
    {
        if (!$timezone instanceof static) {
            return false;
        }

        return $this->getName()->sameValueAs($timezone->getName());
    }

    /**
     * Returns timezone name.
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }

    /**
     * Returns timezone name as string.
     */
    public function __toString(): string
    {
        return $this->getName()->__toString();
    }
}
