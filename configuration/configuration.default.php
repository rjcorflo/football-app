<?php

use function DI\string;

return [
    'database.dsn' => string('sqlite:{app.storageDir}/test.db'),
    'database.user' => '',
    'database.pass' => ''
];
