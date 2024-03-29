<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Web;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\Structure\Dictionary;

/**
 * Class QueryString.
 */
class QueryString extends StringLiteral implements QueryStringInterface
{
    /**
     * Returns a new QueryString.
     */
    public function __construct(string $value)
    {
        if (0 === preg_match('/^\?([\w\.\-[\]~&%+]+(=([\w\.\-~&%+]+)?)?)*$/', $value)) {
            throw new InvalidNativeArgumentException($value, ['string (valid query string)']);
        }

        parent::__construct($value);
    }

    /**
     * Returns a Dictionary structured representation of the query string.
     */
    public function toDictionary(): Dictionary
    {
        $data = [];
        $value = ltrim($this->toNative(), '?');
        parse_str($value, $data);

        return Dictionary::fromNative($data);
    }
}
