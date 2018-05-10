<?php

declare(strict_types=1);

namespace JsonDbQuery;

use Assert\Assertion;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

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

        // just a placeholder
        if (empty($this->adapter)) {
            $this->adapter = $adapter;
        }

        $this->sql = new Sql($adapter);
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
        return $this;
    }

    /**
     * @return Select
     */
    public function generate() : string
    {
        $this->select = $this->sql->select();

        return $this->select;
    }
}
