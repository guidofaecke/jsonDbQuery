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
//         Assertion::notNull($this->tableName);

        $query = json_decode($this->jsonQueryString, true);

        $key = key($query);
        if (array_search($key, $this->logicOperators)) {
            switch ($key) {
                case '$or':
                    $criteria = $this->buildOr(current($query));
                    break;
            }
        }


        $this->query = $this->entityManager->createQueryBuilder();
        $this->query->select('thing');
        $this->query->from($this->tableName, 'thing');
        $this->query->addCriteria($criteria);

        var_dump($this->query->getQuery()->getSQL());
        die();
//             'select t1 from JsonDbQuery\Tests\Models\EntityFixture t1'
//         );


//         return $this->query->getSQL();
    }

    private function buildSql($item, $key)
    {
        var_dump($key);
        var_dump($item);

    }

    private function buildOr(array $query)
    {
        $criteria = new Criteria();

        foreach ($query as $field => $value) {
            $criteria->orWhere(
                $criteria->expr()->eq($field, $value)
            );
        }

        return $criteria;
    }
}