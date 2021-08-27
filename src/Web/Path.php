<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Web;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\StringLiteral\StringLiteral;

/**
 * Class Path.
 */
class Path extends StringLiteral
{
    /**
     * Path constructor.
     */
    public function __construct(string $value)
    {
        $filteredValue = parse_url($value, PHP_URL_PATH);

        if (null === $filteredValue || strlen($filteredValue) !== strlen($value)) {
            throw new InvalidNativeArgumentException($value, ['string (valid url path)']);
        }

        parent::__construct((string)$filteredValue);
    }
}
