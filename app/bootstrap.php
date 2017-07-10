<?php
/**
 * Bootstrap and return application.
 */

// Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
try {
    $dotEnv = new \Dotenv\Dotenv(__DIR__ . '/../');
    $dotEnv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

/** @var \Psr\Container\ContainerInterface $container */
$container = require __DIR__ . '/container/container.php';

return $container->get('app');