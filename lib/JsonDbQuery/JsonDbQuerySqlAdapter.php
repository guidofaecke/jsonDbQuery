<?php

declare(strict_types=1);

namespace JsonDbQuery;

use Assert\Assertion;

class JsonDbQuerySqlAdapter implements JsonDbQueryAdapter
{
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
    public function from($tableName) : self
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
        return 'select * from x';
    }
}
