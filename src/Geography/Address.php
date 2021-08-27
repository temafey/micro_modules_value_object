<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Geography;

use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\ValueObjectInterface;
use BadMethodCallException;

/**
 * Class Address.
 */
class Address implements ValueObjectInterface
{
    /**
     * Name of the addressee (natural person or company).
     */
    protected StringLiteral $name;

    /**
     * Street ValueObject.
     */
    protected Street $street;

    /**
     * District/City area.
     */
    protected StringLiteral $district;

    /**
     * City/Town/Village.
     */
    protected StringLiteral $city;

    /**
     * Region/County/State.
     */
    protected StringLiteral $region;

    /**
     * Postal code/P.O. Box/ZIP code.
     */
    protected StringLiteral $postalCode;

    /**
     * Country
     */
    protected Country $country;

    /**
     * Returns a new Address from native PHP arguments.
     *
     */
    public static function fromNative(): static
    {
        $args = func_get_args();

        if (8 !== count($args)) {
            throw new BadMethodCallException(
                'You must provide exactly 8 arguments: 1) addressee name, 2) street name, 3) street number, 4) district, 5) city, 6) region, 7) postal code, 8) country code.'
            );
        }

        $name = new StringLiteral($args[0]);
        $street = new Street(new StringLiteral($args[1]), new StringLiteral($args[2]));
        $district = new StringLiteral($args[3]);
        $city = new StringLiteral($args[4]);
        $region = new StringLiteral($args[5]);
        $postalCode = new StringLiteral($args[6]);
        $country = Country::fromNative($args[7]);

        return new static($name, $street, $district, $city, $region, $postalCode, $country);
    }

    /**
     * Returns a new Address object.
     */
    public function __construct(
        StringLiteral $name,
        Street $street,
        StringLiteral $district,
        StringLiteral $city,
        StringLiteral $region,
        StringLiteral $postalCode,
        Country $country
    ) {
        $this->name = $name;
        $this->street = $street;
        $this->district = $district;
        $this->city = $city;
        $this->region = $region;
        $this->postalCode = $postalCode;
        $this->country = $country;
    }

    /**
     * Return native value.
     */
    public function toNative(): string
    {
        return $this->__toString();
    }

    /**
     * Tells whether two Address are equal.
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $address): bool
    {
        if (!$address instanceof static) {
            return false;
        }

        return $this->getName()->sameValueAs($address->getName()) &&
            $this->getStreet()->sameValueAs($address->getStreet()) &&
            $this->getDistrict()->sameValueAs($address->getDistrict()) &&
            $this->getCity()->sameValueAs($address->getCity()) &&
            $this->getRegion()->sameValueAs($address->getRegion()) &&
            $this->getPostalCode()->sameValueAs($address->getPostalCode()) &&
            $this->getCountry()->sameValueAs($address->getCountry());
    }

    /**
     * Returns addressee name.
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }

    /**
     * Returns street.
     */
    public function getStreet(): Street
    {
        return clone $this->street;
    }

    /**
     * Returns district.
     */
    public function getDistrict(): StringLiteral
    {
        return clone $this->district;
    }

    /**
     * Returns city.
     */
    public function getCity(): StringLiteral
    {
        return clone $this->city;
    }

    /**
     * Returns region.
     */
    public function getRegion(): StringLiteral
    {
        return clone $this->region;
    }

    /**
     * Returns postal code.
     */
    public function getPostalCode(): StringLiteral
    {
        return clone $this->postalCode;
    }

    /**
     * Returns country.
     */
    public function getCountry(): Country
    {
        return clone $this->country;
    }

    /**
     * Returns a string representation of the Address in US standard format.
     */
    public function __toString(): string
    {
        $format = <<<ADDR
%s
%s
%s %s %s
%s
ADDR;

        return sprintf(
            $format,
            $this->getName()->__toString(),
            $this->getStreet()->__toString(),
            $this->getCity()->__toString(),
            $this->getRegion()->__toString(),
            $this->getPostalCode()->__toString(),
            $this->getCountry()->__toString()
        );
    }
}
