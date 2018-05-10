<?php

declare(strict_types=1);

namespace JsonDbQuery;

interface JsonDbQueryAdapter
{
    /**
     * Place the query string
     *
     * @param string $jsonQueryString The query string
     */
    public function jsonQueryString(string $jsonQueryString) : void;

    /**
     * Set the table
     *
     * @param string|string[] $tableName String or Array Alias => Table Name
     */
    public function from($tableName) : self;

    /**
     * Generate the sql
     *
     * @return string SQL string perhaps
     */
    public function generate() : string;
}
