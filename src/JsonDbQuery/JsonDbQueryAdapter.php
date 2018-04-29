<?php

declare(strct_types=1);

namespace JsonDbQuery;

interface JsonDbQueryAdapter
{
    public function jsonQueryString(string $jsonQueryString)
    {
    }
}
