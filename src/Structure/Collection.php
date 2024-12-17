<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Structure;

use MicroModule\ValueObject\Logical\Boolean;
use MicroModule\ValueObject\NullValue\NullValue;
use MicroModule\ValueObject\Number\Integer;
use MicroModule\ValueObject\Number\Natural;
use MicroModule\ValueObject\Number\Real;
use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\ValueObjectInterface;
use InvalidArgumentException;
use SplFixedArray;

/**
 * Class Collection.
 *
 * @SuppressWarnings(PHPMD)
 */
class Collection implements ValueObjectInterface
{
    /**
     * SplFixedArray object of values.
     */
    protected SplFixedArray $items;

    public function getItems(): iterable
    {
        return $this->items;
    }

    /**
     * Returns a new Collection object.
     */
    public static function fromNative(): static
    {
        $array = func_get_arg(0);
        $items = [];

        if (!is_iterable($array)) {
            throw new InvalidArgumentException('Invalid argument type, expected array.');
        }

        foreach ($array as $item) {
            $item = self::makeValueObject($item);
            $items[] = $item;
        }

        $fixedArray = SplFixedArray::fromArray($items);

        return new static($fixedArray);
    }

    /**
     * Make and return ValueObject from native value.
     */
    protected static function makeValueObject(mixed $item): ValueObjectInterface
    {
        if ($item instanceof ValueObjectInterface) {
            return $item;
        }

        if (is_iterable($item)) {
            return self::isAssocArray($item) ? Dictionary::fromNative($item) : self::fromNative($item);
        }

        if (is_int($item)) {
            $item = Integer::fromNative($item);
        } elseif (is_float($item)) {
            $item = Real::fromNative($item);
        } elseif (null === $item) {
            $item = new NullValue();
        } elseif (is_bool($item)) {
            $item = Boolean::fromNative($item);
        } else {
            $item = StringLiteral::fromNative((string)$item);
        }

        return $item;
    }

    /**
     * Collection constructor.
     */
    public function __construct(SplFixedArray $items)
    {
        foreach ($items as $item) {
            if (false === $item instanceof ValueObjectInterface) {
                $type = is_object($item) ? get_class($item) : gettype($item);

                throw new InvalidArgumentException(
                    sprintf(
                        'Passed SplFixedArray object must contains "ValueObjectInterface" objects only. "%s" given.',
                        $type
                    )
                );
            }
        }

        $this->items = $items;
    }

    /**
     * Tells whether two Collection are equal by comparing their size and items (item order matters).
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $collection): bool
    {
        if (!$collection instanceof static) {
            return false;
        }

        if (false === $this->count()->sameValueAs($collection->count())) {
            return false;
        }
        $arrayCollection = $collection->toArray(false);

        foreach ($this->items as $index => $item) {
            if (!isset($arrayCollection[$index]) || false === $item->sameValueAs($arrayCollection[$index])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the number of objects in the collection.
     */
    public function count(): Natural
    {
        return new Natural($this->items->count());
    }

    /**
     * Tells whether the Collection contains an object.
     */
    public function contains(ValueObjectInterface $object): bool
    {
        foreach ($this->items as $item) {
            if ($item->sameValueAs($object)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return native value.
     */
    public function toNative(): array
    {
        return $this->toArray();
    }

    /**
     * Returns a native array representation of the Collection.
     *
     * @SuppressWarnings(PHPMD)
     */
    public function toArray(bool $native = true): array
    {
        $items = $this->items->toArray();

        if (false === $native) {
            return $items;
        }

        foreach ($items as &$item) {
            if ($item instanceof ValueObjectInterface) {
                $item = $item->toNative();
            }
        }

        return $items;
    }

    /**
     * Returns a native string representation of the Collection object.
     */
    public function __toString(): string
    {
        return serialize($this->toArray());
    }

    /**
     * Validate is associated array.
     */
    protected static function isAssocArray(iterable $array): bool
    {
        $idx = 0;

        foreach ($array as $key => $val) {
            if ($key !== $idx) {
                return true;
            }
            ++$idx;
        }

        return false;
    }
}
