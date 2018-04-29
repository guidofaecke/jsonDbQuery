<?php

namespace JsonDbQuery\Tests;

use Assert\InvalidArgumentException;
use JsonDbQuery\JsonDbQuery;
use PHPUnit\Framework\TestCase;
//use InvalidArgumentException;

/**
 * JsonDbQuery test case.
 */
class JsonDbQueryTest extends TestCase
{

    /**
     *
     * @var JsonDbQuery
     */
    /**
    private $jsonDbQuery;

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

    public function testInstantiateNull()
    {
        $jsonDbQuery = new JsonDbQuery();

        self::assertInstanceOf(JsonDbQuery::class, $jsonDbQuery);
    }

    public function testInstantiateEmpty()
    {
        $jsonDbQuery = new JsonDbQuery('');

        self::assertInstanceOf(JsonDbQuery::class, $jsonDbQuery);
    }

    public function testInstantiateTrue()
    {
        self::expectException(InvalidArgumentException::class);

        $jsonDbQuery = new JsonDbQuery('will not work');
    }

    public function testNoNameYet()
    {
//         $query = '{"status":"pro","title":"yay"}';
        $query = '{"$or":[{"status":"pro"},{"status":"basic"}]}';
        $jdb = new JsonDbQuery($query);
        $test = $jdb->noNameYet();
        var_dump($test);
    }
}

