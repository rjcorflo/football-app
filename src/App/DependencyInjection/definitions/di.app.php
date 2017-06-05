<?php

use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use RJ\PronosticApp\Log\LifecycleLogger;
use RJ\PronosticApp\Persistence\AbstractPersistenceLayer;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Persistence\PersistenceRedBean\RedBeanEntityManager;
use RJ\PronosticApp\Persistence\PersistenceRedBean\RedBeanPersistenceLayer;
use RJ\PronosticApp\Util\Validation\GeneralValidator;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\Fractal\FractalGenerator;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use function DI\get;
use function DI\object;
use function DI\string;

return [
    /* Slim configuration */
    'settings.displayErrorDetails' => false,

    'errorHandler' => DI\object(\RJ\PronosticApp\App\Handlers\ErrorHandler::class)
        ->constructor(DI\get('settings.displayErrorDetails'), get(WebResourceGeneratorInterface::class)),
    'phpErrorHandler' => DI\object(\RJ\PronosticApp\App\Handlers\PhpErrorHandler::class)
        ->constructor(DI\get('settings.displayErrorDetails'), get(WebResourceGeneratorInterface::class)),
    'notFoundHandler' => DI\object(\RJ\PronosticApp\App\Handlers\NotFoundHandler::class),
    'notAllowedHandler' => DI\object(\RJ\PronosticApp\App\Handlers\NotAllowedHandler::class),

    /* Middleware */
    AbstractPersistenceLayer::class => object(RedBeanPersistenceLayer::class),

    /* Data repository */
    'RJ\PronosticApp\Model\Repository\*RepositoryInterface' =>
        object('RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\*Repository'),

    /* Services */
    EntityManager::class => object(RedBeanEntityManager::class),
    WebResourceGeneratorInterface::class => object(FractalGenerator::class),
    ValidatorInterface::class => object(GeneralValidator::class),

    /* Event configuration */
    EventDispatcherInterface::class => function (ContainerInterface $c) {
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($c->get(LifecycleLogger::class));
        return $dispatcher;
    },

    /* Logger configuration */
    'maxLogFiles' => 20,

    StreamHandler::class => object()->constructor(string('{app.logsDir}/logs.log')),
    RotatingFileHandler::class => object()->constructor(string('{app.logsDir}/logger.log'), get('maxLogFiles')),

    'logger.handlers' => [
        get(RotatingFileHandler::class)
    ],

    LoggerInterface::class => function (ContainerInterface $container) {
        $logger = new Logger('REQUEST');
        foreach ($container->get('logger.handlers') as $handlers) {
            $logger->pushHandler($handlers);
        }
        $logger->pushProcessor(new PsrLogMessageProcessor());

        return $logger;
    },
];
