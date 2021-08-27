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
     */
    public function __construct(mixed $value, array $allowedTypes)
    {
        $message = sprintf(
            'Argument "%s" is invalid. Allowed types for argument are "%s".',
            $value,
            implode(', ', $allowedTypes)
        );
        parent::__construct($message);
    }
}
