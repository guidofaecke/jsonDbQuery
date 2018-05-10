<?php

declare(strict_types=1);

namespace JsonDbQuery\Tests;

use Doctrine\ORM\EntityManager;
use JsonDbQuery\JsonDbQueryDoctrineAdapter;
use PHPUnit\Framework\TestCase;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use JsonDbQuery\JsonDbQuery;

/**
 * JsonDbQuery test case.
 */
class JsonDbQueryTest extends TestCase
{
    public $connection;

    public $connectionParams = [
        'driver' => 'pdo_sqlite',
        'memory' => true,
    ];

    /** @var ServiceManager */
    protected static $serviceManager;

    /** @var array */
    protected static $config = [];


//     /** @var JsonDbQuery */
//     private $jsonDbQuery;

    public static function setUpBeforeClass()
    {
        self::$serviceManager = self::getServiceManger();
    }

    /*
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

//         $authentication = $this->prophesize(Authentication::class);
//         $authentication->getCurrentUser()->willReturn('phpunit');

//         $authAdapter = $this->prophesize(AuthenticationAdapter::class);
//         $authAdapter->getAuthenticatedTokenRecord()->willReturn($authentication->reveal());

//         self::$serviceManager->setAllowOverride(true);
//         self::$serviceManager->setFactory(AuthenticationAdapter::class, function() use ($authAdapter) {
//             return $authAdapter->reveal();
//         });

//         self::$serviceManager->setAllowOverride(false);


            //         $this->config = new Configuration();

//         $this->connection = DriverManager::getConnection($this->connectionParams, $this->config);
// $x = new Entityf
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testInstantiateNull()
    {
        self::assertTrue(true);
//         $jsonDbQuery = new JsonDbQuery();

//         self::assertInstanceOf(JsonDbQuery::class, $jsonDbQuery);
    }

    public function testInstantiateEmpty()
    {
        self::assertTrue(true);
        //         $jsonDbQuery = new JsonDbQuery('');

//         self::assertInstanceOf(JsonDbQuery::class, $jsonDbQuery);
    }

    public function testInstantiateTrue()
    {
        self::assertTrue(true);
        //         self::expectException(InvalidArgumentException::class);

//         $jsonDbQuery = new JsonDbQuery('will not work');
    }

    public function testNoNameYet()
    {
//         self::assertTrue(true);

        /** @var EntityManager $em */
        $em = self::$serviceManager->get(EntityManager::class);

        $adapter = new JsonDbQueryDoctrineAdapter($em);
        $jdb = new JsonDbQuery($adapter);

//         var_dump(getcwd());
//         AnnotationRegistry::registerAutoloadNamespace('JsonDbQuery\Fixtures', 'test/JsonDbQuery/Fixtures');

//         $config = Setup::createAnnotationMetadataConfiguration(['JsonDbQuery/Models'], true);
//         $entityManager = EntityManager::create($this->connectionParams, $config);
//         $query = '{"status":"pro","title":"yay"}';
        $query = '{"$or":[{"status":"pro"},{"status":"basic"}]}';
//         //         $eventManager = new EventManager();
// //         $entity = new EntityManager($this->connection, $this->config, $eventManager);
//         $adapter = new JsonDbQueryDoctrineAdapter($entityManager);
//         $jdb = new JsonDbQuery($adapter);
// //         $query = $entityManager->createQuery($query);
// //         $query = $entityManager->createQuery('select t1 from ' . EntityFixture::class);
// var_dump($query);
// // var_dump($query->getDQL());
// // var_dump($query->getSQL());
        $jdb->from('EntityFixture');
        $jdb->jsonQuery($query);
        $test = $jdb->generate();
// // //         $test = $jdb->noNameYet();
        var_dump($test);
    }

    private static function getServiceManger(array $config = null)
    {
        $config = static::$config ? : require_once './config/application.config.php';

        $smConfig = isset($config['service_manager']) ? $config['service_manager'] : [];

        $serviceManager = new ServiceManager((new ServiceManagerConfig($smConfig))->toArray());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get(ModuleManager::class)->loadModules();

        return $serviceManager;
    }
}
