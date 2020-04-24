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
     *
     * @var CountryCode
     */
    protected $code;

    /**
     * Returns a new Country object given a native PHP string country code.
     *
     * @return self
     */
    public static function fromNative(): ValueObjectInterface
    {
        $codeString = func_get_arg(0);
        $code = CountryCode::byName($codeString);

        return new self($code);
    }

    /**
     * Returns a new Country object.
     *
     * @param CountryCode $code
     */
    public function __construct(CountryCode $code)
    {
        $this->code = $code;
    }

    /**
     * Return native value.
     *
     * @return string
     */
    public function toNative()
    {
        return $this->__toString();
    }

    /**
     * Tells whether two Country are equal.
     *
     * @param ValueObjectInterface $country
     *
     * @return bool
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
     *
     * @return CountryCode
     */
    public function getCode(): CountryCode
    {
        return $this->code;
    }

    /**
     * Returns country name.
     *
     * @return StringLiteral
     */
    public function getName(): StringLiteral
    {
        $code = $this->getCode();

        return CountryCodeName::getName($code);
    }

    /**
     * Returns country name as native string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName()->toNative();
    }
}
