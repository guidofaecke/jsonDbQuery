<?php

declare(strict_types=1);

namespace JsonDbQuery;

use Doctrine\ORM\EntityManager;
use Assert\Assertion;

class JsonDbQueryDoctrineAdapter implements JsonDbQueryAdapter
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
}
