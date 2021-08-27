<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Geography;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\Number\Real;
use League\Geotools\Coordinate\Coordinate as BaseCoordinate;

/**
 * Class Latitude.
 */
class Latitude extends Real
{
    /**
     * Returns a new Latitude object.
     *
     * @throws InvalidNativeArgumentException
     */
    public function __construct(float $value)
    {
        // normalization process through Coordinate object
        $coordinate = new BaseCoordinate([$value, 0]);
        $latitude = $coordinate->getLatitude();

        parent::__construct($latitude);
    }
}
