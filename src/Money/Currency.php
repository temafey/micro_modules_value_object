<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Money;

use MicroModule\ValueObject\ValueObjectInterface;
use Money\Currency as BaseCurrency;

/**
 * Class Currency.
 */
class Currency implements ValueObjectInterface
{
    /**
     * Money\Currency object.
     */
    protected BaseCurrency $currency;

    /**
     * CurrencyCode ValueObject.
     */
    protected CurrencyCode $code;

    /**
     * Returns a new Currency object from native string currency code.
     */
    public static function fromNative(): static
    {
        $code = CurrencyCode::get(func_get_arg(0));

        return new static($code);
    }

    /**
     * Currency constructor.
     */
    public function __construct(CurrencyCode $code)
    {
        $this->code = $code;
        $this->currency = new BaseCurrency($code->toNative());
    }

    /**
     * Return native value.
     */
    public function toNative(): string
    {
        return $this->getCode()->toNative();
    }

    /**
     * Tells whether two Currency are equal by comparing their names.
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $currency): bool
    {
        if (!$currency instanceof static) {
            return false;
        }

        return $this->getCode()->toNative() === $currency->getCode()->toNative();
    }

    /**
     * Returns currency code.
     */
    public function getCode(): CurrencyCode
    {
        return $this->code;
    }

    /**
     * Returns string representation of the currency.
     */
    public function __toString(): string
    {
        return $this->getCode()->__toString();
    }
}
