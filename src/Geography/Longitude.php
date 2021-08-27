<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Geography;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\Number\Real;
use League\Geotools\Coordinate\Coordinate as BaseCoordinate;

/**
 * Class Longitude.
 */
class Longitude extends Real
{
    /**
     * Returns a new Longitude object.
     *
     * @throws InvalidNativeArgumentException
     */
    public function __construct(float $value)
    {
        // normalization process through Coordinate object
        $coordinate = new BaseCoordinate([0, $value]);
        $longitude = $coordinate->getLongitude();

        parent::__construct($longitude);
    }
}
