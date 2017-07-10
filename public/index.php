<?php
date_default_timezone_set('Europe/Madrid');
$local = setlocale(LC_TIME, 'es_ES.utf8');

if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

// Bootstrap app
/** @var \Slim\App $app */
$app = require __DIR__ . '/../app/bootstrap.php';

// Run!
$app->run();
