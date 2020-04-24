<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Identity;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\ValueObjectInterface;
use Exception;
use Ramsey\Uuid\Uuid as BaseUuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class UUID.
 */
class UUID extends StringLiteral
{
    /**
     * UuidInterface object.
     *
     * @var UuidInterface
     */
    protected $value;

    /**
     * Return UUID ValueObject.
     *
     * @return UUID|static
     *
     * @throws Exception
     */
    public static function fromNative(): ValueObjectInterface
    {
        $uuidStr = func_get_arg(0);

        return new static($uuidStr);
    }

    /**
     * Generate a new UUID string.
     *
     * @return string
     *
     * @throws Exception
     */
    public static function generateAsString(): string
    {
        $uuid = new static();

        return $uuid->toNative();
    }

    /**
     * UUID constructor.
     *
     * @param string|null $value
     *
     * @throws Exception
     */
    public function __construct(?string $value = null)
    {
        if (null === $value) {
            $this->value = BaseUuid::uuid4();

            return;
        }
        $pattern = '/'.BaseUuid::VALID_PATTERN.'/';

        if (!preg_match($pattern, $value)) {
            throw new InvalidNativeArgumentException($value, ['UUID string']);
        }
        $this->value = BaseUuid::fromString($value);
    }

    /**
     * Returns the value of the string.
     *
     * @return string
     */
    public function toNative()
    {
        return $this->value->toString();
    }

    /**
     * Return Uuid object.
     *
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->value;
    }

    /**
     * Tells whether two UUID are equal by comparing their values.
     *
     * @param ValueObjectInterface $uuid
     *
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $uuid): bool
    {
        if (!$uuid instanceof static) {
            return false;
        }

        return $this->toNative() === $uuid->toNative();
    }

    /**
     * Tells whether the StringLiteral is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return false;
    }
}
