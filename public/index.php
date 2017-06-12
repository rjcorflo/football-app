<?php
date_default_timezone_set('Europe/Madrid');
$local = setlocale(LC_TIME, 'es_ES.utf8');

require '../vendor/autoload.php';

$app = new \RJ\PronosticApp\App\Application();

$app->run();
