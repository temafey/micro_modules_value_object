<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Web;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\StringLiteral\StringLiteral;

/**
 * Class SchemeName.
 */
class SchemeName extends StringLiteral
{
    /**
     * Returns a SchemeName.
     */
    public function __construct(string $value)
    {
        if (0 === preg_match('/^[a-z]([a-z0-9+.-]+)?$/i', $value)) {
            throw new InvalidNativeArgumentException($value, ['string (valid scheme name)']);
        }

        parent::__construct($value);
    }
}
