<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean;

use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RedBeanPHP\R;

/**
 * Class RedBeanEntityManager.
 *
 * Entity manager made via RedBeanPhp library.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean
 */
class RedBeanEntityManager extends EntityManager
{
    /** @var ContainerInterface */
    private $container;

    /**
     * RedBeanEntityManager constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    public function getRepository(string $class)
    {
        return $this->container->get($class);
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
