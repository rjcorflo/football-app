<?php

namespace RJ\FootballApp\Persistence\RedBeanPersistence;

use RedBeanPHP\R;
use RJ\FootballApp\Persistence\AbstractPersistenceLayer;

class RedBeanPersistenceLayer extends AbstractPersistenceLayer
{
    public function initialize()
    {
        define('REDBEAN_MODEL_PREFIX', '\\RJ\\FootballApp\\Persistence\\RedBeanPersistence\\Model\\Entity\\');
        R::setup($this->getContainer()->get('database.dsn'));
    }

    public function finalize()
    {
        R::close();
    }
}
