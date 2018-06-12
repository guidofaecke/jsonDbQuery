<?php

declare(strict_types=1);

namespace JsonDbQuery;

use Assert\Assertion;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class JsonDbQueryDoctrineAdapter extends JsonDbQueryCommon
{
    /** @var EntityManager */
    private $entityManager;

    /** @var string */
    private $jsonQueryString;

    /** @var string */
    private $tableName;

    /** @var QueryBuilder */
    private $query;

    /** @var Criteria */
    private $criteria;

    /**
     * Initialize new instance of JsonDbQDoctrineAdapter
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
     * Set the table
     *
     * {@inheritDoc}
     *
     * @see \JsonDbQuery\JsonDbQueryAdapter::from()
     */
    public function from($tableName)
    {
        if (is_array($tableName)) {
            $this->tableName = (array_values($tableName))[0];

            return $this;
        }

        $this->tableName = $tableName;

        return $this;
    }

    /**
     * Generate something
     *
     * @return string query
     */
    public function generate() : self
    {
        Assertion::notNull($this->tableName);

        $query = json_decode($this->jsonQueryString, true);

        $this->analyze($query);

        return $this;
    }

    public function getCriteria() : Criteria
    {
        return $this->criteria;
    }

    public function getDql()
    {
        $this->query = $this->entityManager->createQueryBuilder();
        $this->query->select('jdbq_');
        $this->query->from($this->tableName, 'jdbq_');
        $this->query->addCriteria($this->criteria);

        return $this->query->getDQL();
    }

    public function getSql() : string
    {
        $this->query = $this->entityManager->createQueryBuilder();
        $this->query->select('jdbq_');
        $this->query->from($this->tableName, 'jdbq_');
        $this->query->addCriteria($this->criteria);

        return $this->query->getQuery()->getSQL();
    }

    private function analyze($query) : Criteria
    {
        $key = key($query);

        $this->criteria = new Criteria();

        if (array_search($key, $this->logicOperators)) {
            switch ($key) {
                case '$or':
                    $this->criteria = $this->buildOr(current($query));
                    break;
                case '$and':
                    $this->criteria = $this->buildAnd(current($query));
                    break;
            }
        }

        if (! array_search($key, $this->logicOperators)) {
            if (is_array($query[$key])) {
                $operator = key($query[$key]);

                if (array_search($operator, $this->conditionalOperators) !== false) {
                    switch ($operator) {
                        case '$gt':
                            $this->criteria = $this->buildGreaterThan($key, $query[$key][key($query[$key])]);
                            break;
                        case '$gte':
                            $this->criteria = $this->buildGreaterThanEqual($key, $query[$key][key($query[$key])]);
                            break;
                        case '$lt':
                            $this->criteria = $this->buildLessThan($key, $query[$key][key($query[$key])]);
                            break;
                        case '$lte':
                            $this->criteria = $this->buildLessThanEqual($key, $query[$key][key($query[$key])]);
                            break;
                    }
                }
            } else {
                $this->criteria = $this->buildAnd($query);
            }
        }

        //         $this->query = $this->entityManager->createQueryBuilder();
        //         $this->query->select('thing');
        //         $this->query->from($this->tableName, 'thing');
        //         $this->query->addCriteria($this->criteria);

        //         return $this->query->getQuery()->getSQL();
        return $this->criteria;
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
        $this->criteria = new Criteria();

        foreach (array_values($query) as $value) {
            $this->criteria->orWhere(
                $this->criteria->expr()->eq(key($value), $value[key($value)])
            );
        }

        return $this->criteria;
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
        $this->criteria = new Criteria();

        foreach (array_values($query) as $value) {
            $this->criteria->andWhere(
                $this->criteria->expr()->eq(key($value), $value[key($value)])
            );
        }

        return $this->criteria;
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
        $this->criteria = new Criteria();

        $this->criteria->where(
            $this->criteria->expr()->gt($field, $value)
        );

        $cx = new Criteria();
        $cx->andWhere(
            $cx->expr()->isNull('description')
        );

        $this->criteria->andWhere($cx->getWhereExpression());

        return $this->criteria;
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
        $this->criteria = new Criteria();

        $this->criteria->where(
            $this->criteria->expr()->gte($field, $value)
        );

        return $this->criteria;
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
        $this->criteria = new Criteria();

        $this->criteria->where(
            $this->criteria->expr()->lt($field, $value)
        );

        return $this->criteria;
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
        $this->criteria = new Criteria();

        $this->criteria->where(
            $this->criteria->expr()->lte($field, $value)
        );

        return $this->criteria;
    }
}
