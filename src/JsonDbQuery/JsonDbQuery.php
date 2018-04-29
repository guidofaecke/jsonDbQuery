<?php

declare(strict_types=1);

namespace JsonDbQuery;

class JsonDbQuery
{
    private $queryAdapter;

    private $jsonQueryString;

    private $decodedQuery;

    public function __construct(JsonDbQueryAdapter $queryAdapter)
    {
        $this->queryAdapter = $queryAdapter;
    }

    public function noNameYet()
    {
        return $this->decodedQuery;
    }
}
