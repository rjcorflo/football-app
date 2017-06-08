<?php
date_default_timezone_set("Europe/Madrid");

require '../vendor/autoload.php';

$app = new \RJ\PronosticApp\App\Application();

$app->run();
