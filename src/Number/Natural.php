<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Number;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\ValueObjectInterface;

/**
 * Class Natural.
 */
class Natural extends Integer
{
    /**
     * Returns a Natural object given a PHP native int as parameter.
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => [
                'min_range' => 0,
            ],
        ];

        $filteredValue = filter_var($value, FILTER_VALIDATE_INT, $options);
        if (false === $filteredValue) {
            throw new InvalidNativeArgumentException($filteredValue, ['int (>=0)']);
        }

        parent::__construct($filteredValue);
    }

    /**
     * @inheritDoc
     */
    public static function fromNative(): static
    {
        $value = func_get_arg(0);
        $value = filter_var($value, FILTER_VALIDATE_INT);
        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['int']);
        }

        return new static($value);
    }
}
