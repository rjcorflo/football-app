<?php

namespace RJ\PronosticApp\Persistence;

/**
 * [abstract description]
 */
abstract class EntityManager
{
    abstract public function getRepositories();

    abstract public function transaction(callable $transaction);

    abstract public function beginTransaction();

    abstract public function commit();

    abstract public function rollback();
}
