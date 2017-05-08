<?php

namespace Persistence\RedBeanPersistence;

use RedBeanPHP\R;
use RJ\FootballApp\Persistence\AbstractPersistenceLayer;

class RedBeanPersistenceLayer extends AbstractPersistenceLayer
{
    public function initialize()
    {
        R::setup();
    }

    public function finalize()
    {
        R::close();
    }
}
