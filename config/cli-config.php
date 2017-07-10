<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use USaq\StaticProxy\Container;

// replace with file to your own project bootstrap
require __DIR__ . '/../app/bootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = Container::get('persistence');

return ConsoleRunner::createHelperSet($entityManager);