<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\DateTime;

use MicroModule\ValueObject\ValueObjectInterface;
use DateTime;
use Exception;

/**
 * Class Time.
 */
class Time implements ValueObjectInterface
{
    /**
     * Hour ValueObject.
     */
    protected Hour $hour;

    /**
     * Minute ValueObject.
     */
    protected Minute $minute;

    /**
     * Second ValueObject.
     */
    protected Second $second;

    /**
     * Returns a nee Time object from native int hour, minute and second.
     *
     * @throws Exception
     */
    public static function fromNative(): static
    {
        $args = func_get_args();

        if (!isset($args[1])) {
            if (!$args[0] instanceof DateTime) {
                $args[0] = new DateTime('@' . strtotime($args[0]));
            }

            return static::fromNativeDateTime($args[0]);
        }

        $hour = new Hour($args[0]);
        $minute = new Minute($args[1]);
        $second = new Second($args[2]);

        return new static($hour, $minute, $second);
    }

    /**
     * Returns a new Time from a native PHP DateTime.
     *
     * @throws Exception
     */
    public static function fromNativeDateTime(DateTime $time): static
    {
        $hour = (int)$time->format('G');
        $minute = (int)$time->format('i');
        $second = (int)$time->format('s');

        return static::fromNative($hour, $minute, $second);
    }

    /**
     * Return native value.
     *
     * @throws Exception
     */
    public function toNative(): DateTime
    {
        return $this->toNativeDateTime();
    }

    /**
     * Returns current Time ValueObject.
     *
     * @throws Exception
     */
    public static function now(): static
    {
        return new static(Hour::now(), Minute::now(), Second::now());
    }

    /**
     * Return zero Time ValueObject.
     */
    public static function zero(): static
    {
        return new static(new Hour(0), new Minute(0), new Second(0));
    }

    /**
     * Returns a new Time objects.
     *
     */
    public function __construct(Hour $hour, Minute $minute, Second $second)
    {
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }

    /**
     * Tells whether two Time are equal by comparing their values.
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $time): bool
    {
        if (!$time instanceof static) {
            return false;
        }

        return $this->getHour()->sameValueAs($time->getHour()) && $this->getMinute()->sameValueAs(
                $time->getMinute()
            ) && $this->getSecond()->sameValueAs($time->getSecond());
    }

    /**
     * Get Hour ValueObject.
     */
    public function getHour(): Hour
    {
        return $this->hour;
    }

    /**
     * Get Minute ValueObject.
     */
    public function getMinute(): Minute
    {
        return $this->minute;
    }

    /**
     * Get Second ValueObject.
     */
    public function getSecond(): Second
    {
        return $this->second;
    }

    /**
     * Returns a native PHP DateTime version of the current Time.
     * Date is set to current.
     *
     * @throws Exception
     */
    public function toNativeDateTime(): DateTime
    {
        $hour = $this->getHour()->toNative();
        $minute = $this->getMinute()->toNative();
        $second = $this->getSecond()->toNative();

        $time = new DateTime('now');
        $time->setTime($hour, $minute, $second);

        return $time;
    }

    /**
     * Returns time as string in format G:i:s.
     *
     * @throws Exception
     */
    public function __toString(): string
    {
        return $this->toNativeDateTime()->format('G:i:s') ?: '';
    }
}
