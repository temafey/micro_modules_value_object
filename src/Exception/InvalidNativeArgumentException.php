<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Exception;

use InvalidArgumentException;

/**
 * Class InvalidNativeArgumentException.
 */
class InvalidNativeArgumentException extends InvalidArgumentException
{
    /**
     * InvalidNativeArgumentException constructor.
     *
     * @param mixed   $value
     * @param mixed[] $allowedTypes
     */
    public function __construct($value, array $allowedTypes)
    {
        $this->message = sprintf('Argument "%s" is invalid. Allowed types for argument are "%s".', $value, implode(', ', $allowedTypes));
    }
}
