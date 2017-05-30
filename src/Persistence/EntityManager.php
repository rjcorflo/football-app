<?php

namespace RJ\PronosticApp\Persistence;

/**
 * [abstract description]
 */
abstract class EntityManager
{
    /**
     * Get entity repository via interface.
     * @param string $entity
     * @return object
     */
    abstract public function getRepository(string $entity);

    /**
     * Perform callable as transaction.
     * @param callable $transaction
     * @return mixed
     */
    abstract public function transaction(callable $transaction);

    /**
     * Begin a transaction.
     * @return mixed
     */
    abstract public function beginTransaction();

    /**
     * @return mixed
     */
    abstract public function commit();

    /**
     * @return mixed
     */
    abstract public function rollback();
}
