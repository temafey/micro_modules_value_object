<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Geography;

use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\ValueObjectInterface;

/**
 * Class Country.
 */
class Country implements ValueObjectInterface
{
    /**
     * CountryCode ValueObject.
     */
    protected CountryCode $code;

    /**
     * Returns a new Country object given a native PHP string country code.
     */
    public static function fromNative(): static
    {
        $codeString = func_get_arg(0);
        $code = CountryCode::byName($codeString);

        return new static($code);
    }

    /**
     * Returns a new Country object.
     */
    public function __construct(CountryCode $code)
    {
        $this->code = $code;
    }

    /**
     * Return native value.
     */
    public function toNative(): string
    {
        return $this->__toString();
    }

    /**
     * Tells whether two Country are equal.
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $country): bool
    {
        if (!$country instanceof static) {
            return false;
        }

        return $this->getCode()->sameValueAs($country->getCode());
    }

    /**
     * Returns country code.
     */
    public function getCode(): CountryCode
    {
        return $this->code;
    }

    /**
     * Returns country name.
     */
    public function getName(): StringLiteral
    {
        $code = $this->getCode();

        return CountryCodeName::getName($code);
    }

    /**
     * Returns country name as native string.
     */
    public function __toString(): string
    {
        return $this->getName()->toNative();
    }
}
