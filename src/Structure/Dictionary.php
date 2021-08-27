<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Structure;

use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\ValueObjectInterface;
use InvalidArgumentException;
use SplFixedArray;

/**
 * Class Dictionary.
 *
 * @SuppressWarnings(PHPMD)
 */
class Dictionary extends Collection
{
    /**
     * Returns a new Dictionary object.
     */
    public static function fromNative(): static
    {
        $array = func_get_arg(0);

        if (!is_iterable($array)) {
            throw new InvalidArgumentException('Invalid argument type, expected array.');
        }
        $keyValuePairs = [];

        foreach ($array as $key => $item) {
            $key = new StringLiteral((string)$key);
            $item = self::makeValueObject($item);
            $keyValuePairs[] = new KeyValuePair($key, $item);
        }
        $fixedArray = SplFixedArray::fromArray($keyValuePairs);

        return new static($fixedArray);
    }

    /**
     * Returns a new Dictionary object.
     */
    public function __construct(SplFixedArray $keyValuePairs)
    {
        foreach ($keyValuePairs as $keyValuePair) {
            if (false === $keyValuePair instanceof KeyValuePair) {
                $type = is_object($keyValuePair) ? get_class($keyValuePair) : gettype($keyValuePair);

                throw new InvalidArgumentException(
                    sprintf('Passed SplFixedArray object must contains "KeyValuePair" objects only. "%s" given.', $type)
                );
            }
        }

        $this->items = $keyValuePairs;
    }

    /**
     * Returns a Collection of the keys.
     */
    public function keys(): Collection
    {
        $count = $this->count()->toNative();
        $keysArray = new SplFixedArray($count);

        foreach ($this->items as $key => $item) {
            $keysArray->offsetSet($key, $item->getKey());
        }

        return new Collection($keysArray);
    }

    /**
     * Returns a Collection of the values.
     */
    public function values(): Collection
    {
        $count = $this->count()->toNative();
        $valuesArray = new SplFixedArray($count);

        foreach ($this->items as $key => $item) {
            $valuesArray->offsetSet($key, $item->getValue());
        }

        return new Collection($valuesArray);
    }

    /**
     * Tells whether $object is one of the keys.
     */
    public function containsKey(ValueObjectInterface $object): bool
    {
        $keys = $this->keys();

        return $keys->contains($object);
    }

    /**
     * Tells whether $object is one of the values.
     */
    public function containsValue(ValueObjectInterface $object): bool
    {
        $values = $this->values();

        return $values->contains($object);
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
        $native = [];

        foreach ($items as $item) {
            /** @var KeyValuePair $item */
            [$key, $value] = $item->toArray();
            $native[$key] = $value;
        }

        return $native;
    }
}
