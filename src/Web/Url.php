<?php

declare(strict_types=1);

namespace MicroModule\ValueObject\Web;

use MicroModule\ValueObject\StringLiteral\StringLiteral;
use MicroModule\ValueObject\ValueObjectInterface;
use Exception;

use function parse_url;

/**
 * Class Url.
 */
class Url implements ValueObjectInterface
{
    /**
     * SchemeName ValueObject.
     */
    protected SchemeName $scheme;

    /**
     * User StringLiteral ValueObject.
     */
    protected StringLiteral $user;

    /**
     * Pass StringLiteral ValueObject.
     */
    protected StringLiteral $password;

    /**
     * Domain ValueObject.
     */
    protected Domain $domain;

    /**
     * Path ValueObject.
     */
    protected Path $path;

    /**
     * PortNumberInterface ValueObject.
     */
    protected PortNumberInterface $port;

    /**
     * QueryString ValueObject.
     */
    protected QueryString $queryString;

    /**
     * FragmentIdentifier ValueObject.
     */
    protected FragmentIdentifier $fragmentIdentifier;

    /**
     * Returns a new Url object from a native url string.
     */
    public static function fromNative(): static
    {
        $urlString = func_get_arg(0);

        $user = parse_url($urlString, PHP_URL_USER);
        $pass = parse_url($urlString, PHP_URL_PASS);
        $host = parse_url($urlString, PHP_URL_HOST);
        $queryString = parse_url($urlString, PHP_URL_QUERY);
        $fragmentId = parse_url($urlString, PHP_URL_FRAGMENT);
        $port = parse_url($urlString, PHP_URL_PORT);

        $scheme = new SchemeName(parse_url($urlString, PHP_URL_SCHEME));
        $user = $user ? new StringLiteral($user) : new StringLiteral('');
        $pass = $pass ? new StringLiteral($pass) : new StringLiteral('');
        $domain = Domain::specifyType($host);
        $path = new Path(parse_url($urlString, PHP_URL_PATH));
        $portNumber = $port ? new PortNumber($port) : new NullPortNumber();
        $query = $queryString ? new QueryString(sprintf('?%s', $queryString)) : new NullQueryString();
        $fragment = $fragmentId ? new FragmentIdentifier(sprintf('#%s', $fragmentId)) : new NullFragmentIdentifier();

        return new static($scheme, $user, $pass, $domain, $portNumber, $path, $query, $fragment);
    }

    /**
     * Returns a new Url object.
     */
    public function __construct(
        SchemeName $scheme,
        StringLiteral $user,
        StringLiteral $password,
        Domain $domain,
        PortNumberInterface $port,
        Path $path,
        QueryString $query,
        FragmentIdentifier $fragment
    ) {
        $this->scheme = $scheme;
        $this->user = $user;
        $this->password = $password;
        $this->domain = $domain;
        $this->path = $path;
        $this->port = $port;
        $this->queryString = $query;
        $this->fragmentIdentifier = $fragment;
    }

    /**
     * Tells whether two Url are sameValueAs by comparing their components.
     *
     * @throws Exception
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $url): bool
    {
        if (!$url instanceof static) {
            return false;
        }

        return $this->getScheme()->sameValueAs($url->getScheme()) &&
            $this->getUser()->sameValueAs($url->getUser()) &&
            $this->getPassword()->sameValueAs($url->getPassword()) &&
            $this->getDomain()->sameValueAs($url->getDomain()) &&
            $this->getPath()->sameValueAs($url->getPath()) &&
            $this->getPort()->sameValueAs($url->getPort()) &&
            $this->getQueryString()->sameValueAs($url->getQueryString()) &&
            $this->getFragmentIdentifier()->sameValueAs($url->getFragmentIdentifier());
    }

    /**
     * Returns the domain of the Url.
     */
    public function getDomain(): Domain
    {
        return clone $this->domain;
    }

    /**
     * Returns the fragment identifier of the Url.
     */
    public function getFragmentIdentifier(): FragmentIdentifier
    {
        return clone $this->fragmentIdentifier;
    }

    /**
     * Returns the password part of the Url.
     */
    public function getPassword(): StringLiteral
    {
        return clone $this->password;
    }

    /**
     * Returns the path of the Url.
     */
    public function getPath(): StringLiteral
    {
        return clone $this->path;
    }

    /**
     * Returns the port of the Url.
     */
    public function getPort(): PortNumberInterface
    {
        return clone $this->port;
    }

    /**
     * Returns the query string of the Url.
     */
    public function getQueryString(): QueryString
    {
        return clone $this->queryString;
    }

    /**
     * Returns the scheme of the Url.
     */
    public function getScheme(): SchemeName
    {
        return clone $this->scheme;
    }

    /**
     * Returns the user part of the Url.
     */
    public function getUser(): StringLiteral
    {
        return clone $this->user;
    }

    /**
     * Return native value.
     */
    public function toNative(): string
    {
        return $this->__toString();
    }

    /**
     * Returns a string representation of the url.
     */
    public function __toString(): string
    {
        $userPass = '';

        if (false === $this->getUser()->isEmpty()) {
            $userPass = sprintf('%s@', $this->getUser()->__toString());

            if (false === $this->getPassword()->isEmpty()) {
                $userPass = sprintf('%s:%s@', $this->getUser()->__toString(), $this->getPassword()->__toString());
            }
        }

        $port = '';

        if (false === NullPortNumber::create()->sameValueAs($this->getPort())) {
            $port = sprintf(':%d', $this->getPort()->toNative());
        }

        return sprintf(
            '%s://%s%s%s%s%s%s',
            $this->getScheme()->__toString(),
            $userPass,
            $this->getDomain()->__toString(),
            $port,
            $this->getPath()->__toString(),
            $this->getQueryString()->__toString(),
            $this->getFragmentIdentifier()->__toString()
        );
    }
}
