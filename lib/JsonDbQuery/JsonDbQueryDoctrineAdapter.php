<?php

declare(strict_types=1);

namespace JsonDbQuery;

use Assert\Assertion;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class JsonDbQueryDoctrineAdapter extends JsonDbQueryCommon implements JsonDbQueryAdapter
{
    /** @var EntityManager */
    private $entityManager;

    /** @var string */
    private $jsonQueryString;

    /** @var string */
    private $tableName;

    /** @var QueryBuilder */
    private $query;

    /**
     * Initialize new instance of JsonDbQueryDoctrineAdapter
     *
     * @param EntityManager $entityManager ORM Entity Manager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritDoc}
     *
     * @see \JsonDbQuery\JsonDbQueryAdapter::jsonQueryString()
     */
    public function jsonQueryString(string $jsonQueryString) : void
    {
        Assertion::isJsonString($jsonQueryString);

        $this->jsonQueryString = $jsonQueryString;
    }

    /**
     * Set the table name
     *
     * {@inheritDoc}
     *
     * @see \JsonDbQuery\JsonDbQueryAdapter::from()
     */
    public function from($tableName) : self
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * Nothing to see here
     */
    public function someTest() : void
    {
        $this->query = $this->entityManager->createQuery();
    }

    /**
     * Generate something
     *
     * @return string query
     */
    public function generate() : string
    {
        Assertion::notNull($this->tableName);

        $query = json_decode($this->jsonQueryString, true);

        $key = key($query);

        if (array_search($key, $this->logicOperators)) {
            switch ($key) {
                case '$or':
                    $criteria = $this->buildOr(current($query));
                    break;
                case '$and':
                    $criteria = $this->buildAnd(current($query));
                    break;
            }
        }

        if (! array_search($key, $this->logicOperators)) {
            $operator = key($query[$key]);

            if (array_search($operator, $this->conditionalOperators) !== false) {
                switch ($operator) {
                    case '$gt':
                        $criteria = $this->buildGreaterThan($key, $query[$key][key($query[$key])]);
                        break;
                    case '$gte':
                        $criteria = $this->buildGreaterThanEqual($key, $query[$key][key($query[$key])]);
                        break;
                    case '$lt':
                        $criteria = $this->buildLessThan($key, $query[$key][key($query[$key])]);
                        break;
                    case '$lte':
                        $criteria = $this->buildLessThanEqual($key, $query[$key][key($query[$key])]);
                        break;
                }
            }
        }

        $this->query = $this->entityManager->createQueryBuilder();
        $this->query->select('thing');
        $this->query->from($this->tableName, 'thing');
        $this->query->addCriteria($criteria);

        return $this->query->getQuery()->getSQL();
    }

    /**
     * Build the OR criteria
     *
     * @param mixed[] $query Column and Value pairs
     *
     * @return Criteria ORM Criteria
     */
    private function buildOr(array $query) : Criteria
    {
        $criteria = new Criteria();

        foreach (array_values($query) as $value) {
            $criteria->orWhere(
                $criteria->expr()->eq(key($value), $value[key($value)])
            );
        }

        return $criteria;
    }

    /**
     * Build the AND criteria
     *
     * @param mixed[] $query Column and Value pairs
     *
     * @return Criteria ORM Criteria
     */
    private function buildAnd(array $query) : Criteria
    {
        $criteria = new Criteria();

        foreach (array_values($query) as $value) {
            $criteria->andWhere(
                $criteria->expr()->eq(key($value), $value[key($value)])
            );
        }

        return $criteria;
    }

    /**
     * Build the GT criteria
     *
     * @param string $field Column Name
     * @param mixed  $value Column Value
     *
     * @return Criteria ORM Criteria
     */
    private function buildGreaterThan(string $field, $value) : Criteria
    {
        $criteria = new Criteria();

        $criteria->where(
            $criteria->expr()->gt($field, $value)
        );

        return $criteria;
    }

    /**
     * Build the GTE criteria
     *
     * @param string $field Column Name
     * @param mixed  $value Column Value
     *
     * @return Criteria ORM Criteria
     */
    private function buildGreaterThanEqual(string $field, $value) : Criteria
    {
        $criteria = new Criteria();

        $criteria->where(
            $criteria->expr()->gte($field, $value)
        );

        return $criteria;
    }

    /**
     * Build the LT criteria
     *
     * @param string $field Column Name
     * @param mixed  $value Column Value
     *
     * @return Criteria ORM Criteria
     */
    private function buildLessThan(string $field, $value) : Criteria
    {
        $criteria = new Criteria();

        $criteria->where(
            $criteria->expr()->lt($field, $value)
        );

        return $criteria;
    }

    /**
     * Build the LTE criteria
     *
     * @param string $field Column Name
     * @param mixed  $value Column Value
     *
     * @return Criteria ORM Criteria
     */
    private function buildLessThanEqual(string $field, $value) : Criteria
    {
        $criteria = new Criteria();

        $criteria->where(
            $criteria->expr()->lte($field, $value)
        );

        return $criteria;
    }
}
