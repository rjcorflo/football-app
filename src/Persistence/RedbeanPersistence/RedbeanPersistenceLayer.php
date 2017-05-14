<?php

namespace RJ\PronosticApp\Persistence\RedBeanPersistence;

use RedBeanPHP\R;
use RJ\PronosticApp\Persistence\AbstractPersistenceLayer;

class RedBeanPersistenceLayer extends AbstractPersistenceLayer
{
    public function initialize()
    {
        define('REDBEAN_MODEL_PREFIX', '\\RJ\\PronosticApp\\Persistence\\RedBeanPersistence\\Model\\Entity\\');
        R::setup($this->getContainer()->get('database.dsn'));
    }

    public function finalize()
    {
        R::close();
    }
}
