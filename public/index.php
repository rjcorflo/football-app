<?php
date_default_timezone_set('Europe/Madrid');
$local = setlocale(LC_ALL, 'es_ES');
error_log(print_r($local, true));

require '../vendor/autoload.php';

$app = new \RJ\PronosticApp\App\Application();

$app->run();
