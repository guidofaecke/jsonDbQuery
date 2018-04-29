<?php

declare(strict_types=1);

namespace JsonDbQuery;

use Zend\Db\Adapter\Adapter;
use Assert\Assertion;

class JsonDbQueryZendDbAdapter extends JsonDbQueryCommon implements JsonDbQueryAdapter
{
    /** @var Adapter */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function jsonQueryString(string $jsonQueryString)
    {
        Assertion::isJsonString($jsonQueryString);

        $this->jsonQueryString = $jsonQueryString;
    }

    public function from($tableName) : self
    {
        return $this;
    }
}
