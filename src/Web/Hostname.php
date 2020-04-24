<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Web;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use Zend\Validator\Hostname as Validator;

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
        $validator = new Validator(['allow' => Validator::ALLOW_DNS | Validator::ALLOW_LOCAL]);

        if (false === $validator->isValid($value)) {
            throw new InvalidNativeArgumentException($value, ['string (valid hostname)']);
        }

        $this->value = $value;
    }
}
