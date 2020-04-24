<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Geography;

use MicroModule\ValueObject\Enum\Enum;

/**
 * Class DistanceFormula.
 */
class DistanceFormula extends Enum
{
    public const FLAT = 'flat';
    public const HAVERSINE = 'haversine';
    public const VINCENTY = 'vincenty';
}
