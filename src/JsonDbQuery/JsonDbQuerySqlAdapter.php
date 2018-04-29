<?php

declare(strict_types=1);

namespace JsonDbQuery;

use Assert\Assertion;

class JsonDbQuerySqlAdapter implements JsonDbQueryAdapter
{
    public function __construct()
    {

    }

    public function jsonQueryString(string $jsonQueryString)
    {
        Assertion::isJsonString($jsonQueryString);

        $this->jsonQueryString = $jsonQueryString;
    }
}
