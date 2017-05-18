<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Persistence\AbstractPersistenceLayer;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\CommunityRepository;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\ParticipantRepository;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\PlayerRepository;
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
    'settings.displayErrorDetails' => true,

    'errorHandler' => DI\object(\RJ\PronosticApp\App\Handlers\ErrorHandler::class)
        ->constructor(DI\get('settings.displayErrorDetails'), get(WebResourceGeneratorInterface::class)),
    'phpErrorHandler' => DI\object(\RJ\PronosticApp\App\Handlers\PhpErrorHandler::class)
        ->constructor(DI\get('settings.displayErrorDetails'), get(WebResourceGeneratorInterface::class)),
    'notFoundHandler' => DI\object(\RJ\PronosticApp\App\Handlers\NotFoundHandler::class),
    'notAllowedHandler' => DI\object(\RJ\PronosticApp\App\Handlers\NotAllowedHandler::class),

    /* Middleware */
    AbstractPersistenceLayer::class => object(RedBeanPersistenceLayer::class),

    /* Data repository */
    PlayerRepositoryInterface::class => object(PlayerRepository::class),
    ParticipantRepositoryInterface::class => object(ParticipantRepository::class),
    CommunityRepositoryInterface::class => object(CommunityRepository::class),

    /* Services */
    WebResourceGeneratorInterface::class => object(FractalGenerator::class),
    ValidatorInterface::class => object(GeneralValidator::class),

    /* Event configuration */
    EventDispatcherInterface::class => object(EventDispatcher::class),

    /* Logger configuration */
    StreamHandler::class => object()->constructor(string('{app.logsDir}/logs.log')),
    'logger.handlers' => [
        get(StreamHandler::class)
    ],
    LoggerInterface::class => function (ContainerInterface $container) {
        $logger = new Logger('logger');
        foreach ($container->get('logger.handlers') as $handlers) {
            $logger->pushHandler($handlers);
        }
        return $logger;
    },
];
