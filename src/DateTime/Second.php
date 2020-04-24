<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\DateTime;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\Number\Natural;
use DateTime;
use Exception;

/**
 * Class Second.
 */
class Second extends Natural
{
    public const MIN_SECOND = 0;
    public const MAX_SECOND = 59;

    /**
     * Returns a new Second object.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => ['min_range' => self::MIN_SECOND, 'max_range' => self::MAX_SECOND],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['int (>=0, <=59)']);
        }

        parent::__construct($value);
    }

    /**
     * Returns the current second.
     *
     * @return Second
     *
     * @throws Exception
     */
    public static function now(): self
    {
        $now = new DateTime('now');
        $second = (int) $now->format('s');

        return new static($second);
    }
}
