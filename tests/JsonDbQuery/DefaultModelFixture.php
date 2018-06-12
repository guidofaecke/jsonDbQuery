<?php

namespace JsonDbQuery\Tests;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

class DefaultModelFixture
{
    /** @var ServiceManager */
    protected static $serviceManager;

    /** @var array */
    protected static $config = [];

    public static function setUpBeforeClass()
    {
        self::$serviceManager = self::getServiceManger();
    }

    private static function getApplicationConfig()
    {
        return static::$config;
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
