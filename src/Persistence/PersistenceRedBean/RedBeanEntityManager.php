<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean;

use RJ\PronosticApp\Persistence\EntityManager;
use RedBeanPHP\R;

class RedBeanEntityManager extends EntityManager
{
    /**
     * @inheritDoc
     */
    public function getRepositories()
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function transaction(callable $transaction)
    {
        return R::transaction($transaction);
    }

    /**
     * @inheritDoc
     */
    public function beginTransaction()
    {
        R::begin();
    }

    /**
     * @inheritDoc
     */
    public function commit()
    {
        R::commit();
    }

    /**
     * @inheritDoc
     */
    public function rollback()
    {
        R::rollback();
    }
}
