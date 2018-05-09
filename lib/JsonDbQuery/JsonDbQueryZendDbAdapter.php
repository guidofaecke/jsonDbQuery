<?php

declare(strict_types=1);

namespace JsonDbQuery;

use Zend\Db\Adapter\Adapter;
use Assert\Assertion;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

class JsonDbQueryZendDbAdapter extends JsonDbQueryCommon implements JsonDbQueryAdapter
{
    /** @var Adapter */
    private $adapter;

    /** @var Sql */
    private $sql;

    /** @var Select */
    private $select;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;

        $this->sql = new Sql($adapter);
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

    /**
     *
     * @return Select
     */
    public function generate()
    {
        $this->select = $this->sql->select();

        return $this->select;
    }
}
