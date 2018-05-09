<?php

// declare(strict_types=1);

error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('UTC');

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    // dependencies were installed via composer - this is the main project
    require __DIR__ . '/../vendor/autoload.php';
} else {
    throw new \Exception('Can\'t find autoload.php. Did you install dependencies via composer?');
}
