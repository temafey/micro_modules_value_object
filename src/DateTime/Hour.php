<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\DateTime;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\Number\Natural;
use MicroModule\ValueObject\ValueObjectInterface;
use DateTime;
use Exception;

/**
 * Class Hour.
 */
class Hour extends Natural
{
    public const MIN_HOUR = 0;
    public const MAX_HOUR = 23;

    /**
     * Returns a new Hour from native int value.
     */
    public static function fromNative(): static
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns a new Hour object.
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => ['min_range' => self::MIN_HOUR, 'max_range' => self::MAX_HOUR],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['int (>=0, <=23)']);
        }

        parent::__construct($value);
    }

    /**
     * Returns the current hour.
     */
    public static function now(): self
    {
        $now = new DateTime('now');
        $hour = (int)$now->format('G');

        return new static($hour);
    }
}
