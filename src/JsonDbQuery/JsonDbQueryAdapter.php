<?php

declare(strct_types=1);

namespace JsonDbQuery;

interface JsonDbQueryAdapter
{
    public function jsonQueryString(string $jsonQueryString)
    {
    }

    /**
     *
     * @param string|string[] $tableName String or Array Alias => Table Name
     */
    public function from($tableName)
    {
    }
}
