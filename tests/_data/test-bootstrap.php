<?php

// Composer autoloader
require_once __DIR__ . '/../../vendor/autoload.php';

// Load environment variables
try {
    $dotEnv = new \Dotenv\Dotenv(__DIR__);
    $dotEnv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

// Require container
$container = require __DIR__ . '/../../app/container/container.php';

// Return container
return $container;
