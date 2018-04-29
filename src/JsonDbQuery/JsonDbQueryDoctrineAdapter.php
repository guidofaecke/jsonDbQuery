<?php

declare(strict_types=1);

namespace JsonDbQuery;

use Assert\Assertion;
use Doctrine\ORM\EntityManager;

class JsonDbQueryDoctrineAdapter extends JsonDbQueryCommon implements JsonDbQueryAdapter
{
    /** @var EntityManager */
    private $entityManager;

    /** @var string */
    private $jsonQueryString;

    /**
     * Initialize new instance of JsonDbQueryDoctrineAdapter
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function jsonQueryString(string $jsonQueryString)
    {
        Assertion::isJsonString($jsonQueryString);

        $this->jsonQueryString = $jsonQueryString;
    }

    /**
     *
     * {@inheritDoc}
     * @see \JsonDbQuery\JsonDbQueryAdapter::from()
     */
    public function from($tableName)
    {
        return $this;
    }
}
