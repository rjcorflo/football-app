#!/usr/bin/env php
<?php
/**
 * Console application.
 */
set_time_limit(0);

require __DIR__ . '/../vendor/autoload.php';

use Robo\Robo;
use USaq\App\Console\ApplicationConsole;

// Load environment variables
try {
    $dotEnv = new \Dotenv\Dotenv(__DIR__ . '/../');
    $dotEnv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

$input = new \Symfony\Component\Console\Input\ArgvInput($argv);
$output = new \Symfony\Component\Console\Output\ConsoleOutput();

$container = require __DIR__ . '/container/container.php';

$config = Robo::createConfiguration([ __DIR__ . '/../config/console.yml']);
$app = new ApplicationConsole($config, $input, $output, $container);
$status_code = $app->run($input, $output);
exit($status_code);