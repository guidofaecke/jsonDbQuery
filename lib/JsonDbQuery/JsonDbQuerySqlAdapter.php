<?php

declare(strict_types=1);

namespace JsonDbQuery;

use Assert\Assertion;

class JsonDbQuerySqlAdapter implements JsonDbQueryAdapter
{
    /** @var string */
    private $jsonQueryString;

    public function __construct()
    {
    }

    public function jsonQueryString(string $jsonQueryString) : void
    {
        Assertion::isJsonString($jsonQueryString);

        $this->jsonQueryString = $jsonQueryString;
    }

    /**
     * {@inheritDoc}
     *
     * @see \JsonDbQuery\JsonDbQueryAdapter::from()
     */
    public function from($tableName)
    {
        // TODO Auto-generated method stub
    }

    /**
     * Generate SQL statement
     *
     * @return string test sql
     */
    public function generate() : string
    {
        $notDefinedYet = $this->jsonQueryString;

        return 'select * from x';
    }
}
