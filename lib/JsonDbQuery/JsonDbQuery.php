<?php

declare(strict_types=1);

namespace JsonDbQuery;

class JsonDbQuery
{
    /** @var JsonDbQueryAdapter */
    private $queryAdapter;

    public function __construct(JsonDbQueryAdapter $queryAdapter)
    {
        $this->queryAdapter = $queryAdapter;
    }

    /**
     * Set the table name
     *
     * @param string $table table name
     *
     * @return self Provides a fluent interface
     */
    public function from(string $table) : self
    {
        $this->queryAdapter->from($table);

        return $this;
    }

    public function jsonQuery(string $jsonQuery) : void
    {
        $this->queryAdapter->jsonQueryString($jsonQuery);
    }

    public function generate() : string
    {
        return $this->queryAdapter->generate();
    }
}
