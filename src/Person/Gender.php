<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Person;

use MicroModule\ValueObject\Enum\Enum;

/**
 * Class Gender.
 */
class Gender extends Enum
{
    public const MALE = 'male';
    public const FEMALE = 'female';
    public const OTHER = 'other';
}
