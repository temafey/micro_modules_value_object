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
     * @return Dictionary
     */
    public function toDictionary(): Dictionary;
}
