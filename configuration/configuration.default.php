<?php
/**
 * This file is the template with all parameters needed for correct use of Application.
 *
 * This should be renamed as configuration.php and filled with correct parameters.
 */

use function DI\string;

return [
    'database.dsn' => string('sqlite:{app.storageDir}/database/test.db'),
    'database.user' => '',
    'database.pass' => '',
    'module.footballdata.apikey' => ''
];
