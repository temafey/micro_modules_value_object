<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Money;

use MicroModule\ValueObject\Number\Integer as IntegerValueObject;
use MicroModule\ValueObject\Number\Real;
use MicroModule\ValueObject\Number\RoundingMode;
use MicroModule\ValueObject\ValueObjectInterface;
use Money\Currency as BaseCurrency;
use Money\Money as BaseMoney;

/**
 * Class Money.
 */
class Money implements ValueObjectInterface
{
    /**
     * Money\Money object.
     */
    protected BaseMoney $money;

    /**
     * Currency ValueObject.
     */
    protected Currency $currency;

    /**
     * Returns a Money object from native int amount and string currency code.
     */
    public static function fromNative(): static
    {
        $args = func_get_args();

        $amount = new IntegerValueObject($args[0]);
        $currency = Currency::fromNative($args[1]);

        return new static($amount, $currency);
    }

    /**
     * Returns a Money object.
     */
    public function __construct(IntegerValueObject $amount, Currency $currency)
    {
        $baseCurrency = new BaseCurrency($currency->getCode()->toNative());
        $this->money = new BaseMoney($amount->toNative(), $baseCurrency);
        $this->currency = $currency;
    }

    /**
     * Return native value.
     */
    public function toNative(): string
    {
        return $this->__toString();
    }

    /**
     *  Tells whether two Currency are equal by comparing their amount and currency.
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $money): bool
    {
        if (!$money instanceof static) {
            return false;
        }

        return $this->getAmount()->sameValueAs($money->getAmount()) && $this->getCurrency()->sameValueAs(
                $money->getCurrency()
            );
    }

    /**
     * Returns money amount.
     */
    public function getAmount(): IntegerValueObject
    {
        return new IntegerValueObject((int)$this->money->getAmount());
    }

    /**
     * Returns money currency.
     */
    public function getCurrency(): Currency
    {
        return clone $this->currency;
    }

    /**
     * Add an integer quantity to the amount and returns a new Money object.
     * Use a negative quantity for subtraction.
     *
     * @param IntegerValueObject $quantity Quantity to add
     */
    public function add(IntegerValueObject $quantity): self
    {
        $amount = new IntegerValueObject($this->getAmount()->toNative() + $quantity->toNative());

        return new static($amount, $this->getCurrency());
    }

    /**
     * Multiply the Money amount for a given number and returns a new Money object.
     * @param Real $multiplier Use 0 < Real $multiplier < 1 for division
     * @param RoundingMode|null $roundingMode Rounding mode of the operation. Defaults to RoundingMode::HALF_UP.
     */
    public function multiply(Real $multiplier, ?RoundingMode $roundingMode = null): self
    {
        if (null === $roundingMode) {
            $roundingMode = RoundingMode::HALF_UP();
        }

        $amount = $this->getAmount()->toNative() * $multiplier->toNative();
        $roundedAmount = new IntegerValueObject((int)round($amount, 0, $roundingMode->toNative()));

        return new static($roundedAmount, $this->getCurrency());
    }

    /**
     * Returns a string representation of the Money value in format "CUR AMOUNT" (e.g.: EUR 1000).
     */
    public function __toString(): string
    {
        return sprintf('%s %d', $this->getCurrency()->getCode()->__toString(), $this->getAmount()->toNative());
    }
}
