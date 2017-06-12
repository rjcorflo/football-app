<?php
date_default_timezone_set('Europe/Madrid');
setlocale(LC_ALL, 'es_ES');

require '../vendor/autoload.php';

$app = new \RJ\PronosticApp\App\Application();

$app->run();
