<?php

declare(strict_types=1);

namespace JsonDbQuery\Tests;

use Doctrine\ORM\EntityManager;
use JsonDbQuery\JsonDbQueryDoctrineAdapter;
use JsonDbQuery\Tests\Fixtures\TestEntity;
use PHPUnit\Framework\TestCase;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\Expr\Comparison;

/**
 * JsonDbQuery test case.
 */
class JsonDbQueryDoctrineTest extends TestCase
{
    public $connection;

    public $connectionParams = [
        'driver' => 'pdo_sqlite',
        'memory' => true,
    ];

    /** @var ServiceManager */
    protected static $serviceManager;

    /** @var EntityManager */
    protected static $entityManager;

    /** @var array */
    protected static $config = [];

    public static function setUpBeforeClass()
    {
        self::$serviceManager = self::getServiceManger();
        self::$entityManager  = self::$serviceManager->get(EntityManager::class);
    }

    /*
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testOr()
    {
        $jdbq = new JsonDbQueryDoctrineAdapter(self::$entityManager);

        $query = '{"$or":[{"status":"pro"},{"status":"basic"}]}';

        $jdbq->from(TestEntity::class);
        $jdbq->jsonQueryString($query);
        $jdbq->generate();

        $dql = $jdbq->getDql();
        $sql = $jdbq->getSql();

        $criteria = $jdbq->getCriteria();

        $where = $criteria->getWhereExpression();
        self::assertInstanceOf(CompositeExpression::class, $where);

        self::assertEquals(CompositeExpression::TYPE_OR, $where->getType());

        self::assertEquals('SELECT t0_.STATUS AS STATUS_0, t0_.DESCRIPTION AS DESCRIPTION_1, t0_.CREATED_ON AS CREATED_ON_2 FROM TEST_TABLE t0_ WHERE t0_.STATUS = ? OR t0_.STATUS = ?', $sql);
        self::assertEquals('SELECT jdbq_ FROM JsonDbQuery\Tests\Fixtures\TestEntity jdbq_ WHERE jdbq_.status = :status OR jdbq_.status = :status_1', $dql);
    }

    public function testAnd()
    {
        $jdbq = new JsonDbQueryDoctrineAdapter(self::$entityManager);

        $query = '{"$and":[{"status":"pro","title":"yay"}]}';

        $jdbq->from(TestEntity::class);
        $jdbq->jsonQueryString($query);
        $jdbq->generate();

        $criteria = $jdbq->getCriteria();

        $where = $criteria->getWhereExpression();
        self::assertInstanceOf(Comparison::class, $where);
    }

    public function testLt()
    {
        $jdbq = new JsonDbQueryDoctrineAdapter(self::$entityManager);

        $query = '{"status":{"$gt":"500", "$lt":"400"}}';

        $jdbq->from(TestEntity::class);
        $jdbq->jsonQueryString($query);
        $jdbq->generate();

        $criteria = $jdbq->getCriteria();

        $where = $criteria->getWhereExpression();

//         var_dump($jdbq->getSql());
        self::assertInstanceOf(Comparison::class, $where);
    }

    public function testSomething()
    {
        echo PHP_EOL;
        //$array = json_decode('{ "status": "A" }');
        $array = json_decode('{"status":{"$not":{ "$or": [ { "status": "A" } ,{ "age": 50 } ] }}}', true);
//         $array = json_decode('{ "status": "A", "age": 50 }', true);
//         $array = json_decode('{ "$or": [ { "status": "A" } ,{ "age": 50 } ] }', true);
// var_dump($array);
//         var_dump(key($array));
        array_walk($array, [$this, 'justWalking']);

    }

    private function justWalking(&$item, $key)
    {
        if (is_array($item)) {
            var_dump($key);
            array_walk($item, [$this, 'justWalking']);
        } else {

        var_dump('!!!!!');
        var_dump($key);
        var_dump($item);
        }
    }

    /**
     * Get the service manager
     *
     * @param mixed[] $config
     *
     * @return ServiceManager
     */
    private static function getServiceManger(array $config = null) : ServiceManager
    {
        $config = static::$config ? : require_once './tests/config/application.config.php';

        $smConfig = isset($config['service_manager']) ? $config['service_manager'] : [];

        $serviceManager = new ServiceManager((new ServiceManagerConfig($smConfig))->toArray());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get(ModuleManager::class)->loadModules();

        return $serviceManager;
    }
}
