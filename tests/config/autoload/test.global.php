<?php

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => Doctrine\DBAL\Driver\PDOSqlite\Driver::class,
                'params' => [
                    'path' => 'data/phpunit.sqlite3',
                ],
            ],
        ],
        'driver' => [
            'Doctrine_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../../JsonDbQuery/Fixtures',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'JsonDbQuery\\Tests\\Fixtures' => 'Doctrine_driver',
                ],
            ],
        ],
    ],
    'db' => [
        'database' => 'data/phpunit.sqlite3',
        'driver' => 'PDO_Sqlite',
    ],
];
