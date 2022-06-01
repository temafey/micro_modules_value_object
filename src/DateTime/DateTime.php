<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\DateTime;

use MicroModule\ValueObject\DateTime\Exception\InvalidDateException;
use MicroModule\ValueObject\ValueObjectInterface;
use DateTime as BaseDateTime;
use Exception;

class DateTime implements ValueObjectInterface
{
    /**
     * Date ValueObject.
     */
    protected Date $date;

    /**
     * Date ValueObject.
     */
    protected Time $time;

    /**
     * Returns a new DateTime object from native values.
     *
     * @throws InvalidDateException|Exception
     */
    public static function fromNative(): static
    {
        $args = func_get_args();

        if (!isset($args['1'])) {
            if (is_string($args[0])) {
                $dateTime = new BaseDateTime('@'.strtotime($args[0]));
            } elseif (is_array($args[0])) {
                $dateTime = new BaseDateTime('@'.strtotime($args[0][1]));
            } else {
                $dateTime = $args[0];
            }

            return self::fromNativeDateTime($dateTime);
        }

        $date = Date::fromNative($args[0], $args[1], $args[2]);
        $time = Time::fromNative($args[3], $args[4], $args[5]);

        return new static($date, $time);
    }

    /**
     * Return native value.
     * @throws Exception
     */
    public function toNative(): BaseDateTime
    {
        return $this->toNativeDateTime();
    }

    /**
     * Returns a new DateTime from a native PHP DateTime.
     *
     * @throws InvalidDateException
     */
    public static function fromNativeDateTime(BaseDateTime $dateTime): static
    {
        $date = Date::fromNativeDateTime($dateTime);
        $time = Time::fromNativeDateTime($dateTime);

        return new static($date, $time);
    }

    /**
     * Returns current DateTime.
     *
     * @throws InvalidDateException|Exception
     */
    public static function now(): self
    {
        return new static(Date::now(), Time::now());
    }

    /**
     * Returns a new DateTime object.
     */
    public function __construct(Date $date, ?Time $time = null)
    {
        $this->date = $date;

        if (null === $time) {
            $time = Time::zero();
        }

        $this->time = $time;
    }

    /**
     * Tells whether two DateTime are equal by comparing their values.
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $dateTime): bool
    {
        if (!$dateTime instanceof static) {
            return false;
        }

        return $this->getDate()->sameValueAs($dateTime->getDate()) && $this->getTime()->sameValueAs(
                $dateTime->getTime()
            );
    }

    /**
     * Returns date from current DateTime.
     */
    public function getDate(): Date
    {
        return clone $this->date;
    }

    /**
     * Returns time from current DateTime.
     */
    public function getTime(): Time
    {
        return clone $this->time;
    }

    /**
     * Returns a native PHP DateTime version of the current DateTime.
     *
     * @throws Exception
     */
    public function toNativeDateTime(): BaseDateTime
    {
        $year = $this->getDate()->getYear()->toNative();
        $month = $this->getDate()->getMonth()->getNumericValue();
        $day = $this->getDate()->getDay()->toNative();
        $hour = $this->getTime()->getHour()->toNative();
        $minute = $this->getTime()->getMinute()->toNative();
        $second = $this->getTime()->getSecond()->toNative();

        $dateTime = new BaseDateTime();
        $dateTime->setDate($year, $month, $day);
        $dateTime->setTime($hour, $minute, $second);

        return $dateTime;
    }

    /**
     * Returns DateTime as string in format "Y-n-j G:i:s".
     *
     * @return string
     *
     * @throws Exception
     */
    public function __toString(): string
    {
        return sprintf('%s %s', $this->getDate()->__toString(), $this->getTime()->__toString());
    }
}
