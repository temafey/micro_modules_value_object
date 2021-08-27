<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Web;

use MicroModule\ValueObject\Structure\Dictionary;

/**
 * Interface QueryStringInterface.
 */
interface QueryStringInterface
{
    /**
     * Returns Dictionary ValueObject
     */
    public function toDictionary(): Dictionary;
}
