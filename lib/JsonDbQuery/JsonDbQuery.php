<?php

declare(strict_types=1);

namespace JsonDbQuery;

class JsonDbQuery
{
    private $queryAdapter;

    private $jsonQuery;

    private $decodedQuery;

    private $table;

    public function __construct(JsonDbQueryAdapter $queryAdapter)
    {
        $this->queryAdapter = $queryAdapter;
    }

    /**
     *
     * @param string $table
     *
     * @return self Provides a fluent interface
     */
    public function from(string $table) : self
    {
        $this->queryAdapter->from($table);

        return $this;
    }

    public function jsonQuery(string $jsonQuery)
    {
        $this->queryAdapter->jsonQueryString($jsonQuery);
    }

    public function generate()
    {
        return $this->queryAdapter->generate();
    }
}
