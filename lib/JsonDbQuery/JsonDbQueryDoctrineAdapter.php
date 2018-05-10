<?php

declare(strict_types=1);

namespace JsonDbQuery;

use Assert\Assertion;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
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
        $this->tableName = $tableName;

        return $this;
    }

    public function someTest()
    {
        $this->query = $this->entityManager->createQuery();
    }

    /**
     *
     * @return Query
     */
    public function generate()
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
                    case '$gte':
                        $criteria = $this->buildGreaterThanEqual($key, $query[$key][key($query[$key])]);
                    case '$lt':
                        $criteria = $this->buildLessThan($key, $query[$key][key($query[$key])]);
                    case '$lte':
                        $criteria = $this->buildLessThanEqual($key, $query[$key][key($query[$key])]);
                }
            }

        }

        $this->query = $this->entityManager->createQueryBuilder();
        $this->query->select('thing');
        $this->query->from($this->tableName, 'thing');
        $this->query->addCriteria($criteria);
    }

    private function buildSql($item, $key)
    {
        var_dump($key);
        var_dump($item);

    }

    private function buildOr(array $query)
    {
        $criteria = new Criteria();

        foreach (array_values($query) as $value) {
            $criteria->orWhere(
                $criteria->expr()->eq(key($value), $value[key($value)])
            );
        }

        return $criteria;
    }

    private function buildAnd(array $query)
    {
        $criteria = new Criteria();

        foreach (array_values($query) as $value) {
            $criteria->andWhere(
                $criteria->expr()->eq(key($value), $value[key($value)])
            );
        }

        return $criteria;
    }

    private function buildGreaterThan($field, $value)
    {
        $criteria = new Criteria();

        $criteria->where(
            $criteria->expr()->gt($field, $value)
        );

        return $criteria;
    }

    private function buildGreaterThanEqual($field, $value)
    {
        $criteria = new Criteria();

        $criteria->where(
            $criteria->expr()->gte($field, $value)
        );

        return $criteria;
    }

    private function buildLessThan($field, $value)
    {
        $criteria = new Criteria();

        $criteria->where(
            $criteria->expr()->lt($field, $value)
            );

        return $criteria;
    }

    private function buildLessThanEqual($field, $value)
    {
        $criteria = new Criteria();

        $criteria->where(
            $criteria->expr()->lte($field, $value)
        );

        return $criteria;
    }
}