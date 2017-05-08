<?php

namespace RJ\FootballApp\Persistence;

use Psr\Container\ContainerInterface;

abstract class AbstractPersistenceLayer
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * PersistenceLayer constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get DI container.
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Initialize persistence layer if necessary.
     *
     * @return void
     */
    abstract public function initialize();

    /**
     * Finalize and free persistence  resources.
     *
     * @return void
     */
    abstract public function finalize();
}
