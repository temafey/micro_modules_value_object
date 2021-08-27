<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Util;

/**
 * Class Util.
 * Utility class for methods used all across the library.
 */
class Util
{
    /**
     * Tells whether two objects are of the same class.
     */
    public static function classEquals(object $objectA, object $objectB): bool
    {
        return get_class($objectA) === get_class($objectB);
    }

    /**
     * Returns full namespaced class as string.
     */
    public static function getClassAsString(object $object): string
    {
        return get_class($object);
    }
}
