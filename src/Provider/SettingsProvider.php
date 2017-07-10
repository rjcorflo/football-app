<?php

namespace RJ\PronosticApp\Provider;

use function DI\get;
use function DI\object;
use function DI\string;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\App\Handlers\ErrorHandler;
use RJ\PronosticApp\App\Handlers\NotAllowedHandler;
use RJ\PronosticApp\App\Handlers\NotFoundHandler;
use RJ\PronosticApp\App\Handlers\PhpErrorHandler;
use RJ\PronosticApp\Log\LifecycleLogger;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Persistence\PersistenceRedBean\RedBeanEntityManager;
use RJ\PronosticApp\Util\Validation\GeneralValidator;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\Fractal\FractalGenerator;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Provides basic settings information.
 */
class SettingsProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function registerServices(): array
    {
        return [
            'dir.base' => __DIR__ . '/../..',
            'dir.cache' => string('{dir.base}/cache'),
            'dir.config' => string('{dir.base}/config'),
            'dir.docs' => string('{dir.base}/docs'),
            'dir.logs' => string('{dir.base}/logs'),
            'dir.src' => string('{dir.base}/src'),
            'dir.src.entities' => string('{dir.src}/Model/Entity'),
            'dir.storage' => string('{dir.base}/storage'),

            'settings.determineRouteBeforeAppMiddleware' => false,
            'settings.displayErrorDetails' => false,

            // Handlers
            'errorHandler' => \DI\object(ErrorHandler::class)
                ->constructor(\DI\get('settings.displayErrorDetails'), get(WebResourceGeneratorInterface::class)),
            'phpErrorHandler' => \DI\object(PhpErrorHandler::class)
                ->constructor(\DI\get('settings.displayErrorDetails'), get(WebResourceGeneratorInterface::class)),
            'notFoundHandler' => \DI\object(NotFoundHandler::class),
            'notAllowedHandler' => \DI\object(NotAllowedHandler::class),

            /* Event configuration */
            EventDispatcherInterface::class => function (ContainerInterface $container) {
                $dispatcher = new EventDispatcher();
                $dispatcher->addSubscriber($container->get(LifecycleLogger::class));
                return $dispatcher;
            },

            /* Data repository */
            'RJ\PronosticApp\Model\Repository\*RepositoryInterface' =>
                object('RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\*Repository'),

            /* Services */
            EntityManager::class => object(RedBeanEntityManager::class),
            WebResourceGeneratorInterface::class => object(FractalGenerator::class),
            ValidatorInterface::class => object(GeneralValidator::class),
        ];
    }

    /**
     * @inheritdoc
     */
    public function registerServicesDevelopment(): array
    {
        return [
            'settings.displayErrorDetails' => true,
        ];
    }

    /**
     * @inheritdoc
     */
    public function registerServicesTest(): array
    {
        return [];
    }
}
