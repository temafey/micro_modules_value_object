<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Identity;

use InvalidArgumentException;
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
    protected const UUID_VERSION_4 = 4;

    protected const UUID_VERSION_6 = 6;

    protected int $uuidVersion = self::UUID_VERSION_6;

    /**
     * UuidInterface object.
     */
    protected UuidInterface $uuid;

    /**
     * Return UUID ValueObject.
     *
     * @throws Exception
     */
    public static function fromNative(): static
    {
        $uuidStr = func_get_arg(0);

        return new static($uuidStr);
    }

    /**
     * Generate a new UUID string.
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
     * @throws Exception
     */
    public function __construct(?string $value = null)
    {
        if (null !== $value && !BaseUuid::isValid($value)) {
            throw new InvalidNativeArgumentException($value, ['UUID string']);
        }
        if (null === $value) {
            $this->uuid = $this->generateUuid();
        } else {
            $this->uuid = BaseUuid::fromString($value);
        }

        parent::__construct($this->uuid->toString());
    }

    /**
     * Return Uuid object.
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * Tells whether two UUID are equal by comparing their values.
     */
    public function sameValueAs(ValueObjectInterface $uuid): bool
    {
        if (!$uuid instanceof static) {
            return false;
        }

        return $this->toNative() === $uuid->toNative();
    }

    /**
     * Tells whether the StringLiteral is empty
     */
    public function isEmpty(): bool
    {
        return false;
    }

    /**
     * Returns new generated Uuid
     */
    protected function generateUuid(): UuidInterface
    {
        return match ($this->uuidVersion) {
            self::UUID_VERSION_4 => BaseUuid::uuid4(),
            self::UUID_VERSION_6 => BaseUuid::uuid6(),
            default => throw new InvalidArgumentException(sprintf('Unknown Uuid version: `%d`!', $this->uuidVersion))
        };
    }
}
