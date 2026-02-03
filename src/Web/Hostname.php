<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Web;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;

/**
 * Class Hostname.
 */
class Hostname extends Domain
{
    /**
     * Returns a Hostname.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (false === filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            throw new InvalidNativeArgumentException($value, ['string (valid hostname)']);
        }

        parent::__construct($value);
    }
}
