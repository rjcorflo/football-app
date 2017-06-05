<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean;

use RedBeanPHP\R;
use RJ\PronosticApp\Persistence\AbstractPersistenceLayer;

/**
 * Class RedBeanPersistenceLayer.
 *
 * Persistence layer via RedBeanPhp library.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean
 */
class RedBeanPersistenceLayer extends AbstractPersistenceLayer
{
    /**
     * @inheritdoc
     */
    public function initialize()
    {
        define('REDBEAN_MODEL_PREFIX', '\\RJ\\PronosticApp\\Persistence\\PersistenceRedBean\\Model\\Entity\\');
        R::setup($this->getContainer()->get('database.dsn'));
    }

    /**
     * @inheritdoc
     */
    public function finalize()
    {
        R::close();
    }
}
