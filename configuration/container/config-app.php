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

    /* Middleware */
    AbstractPersistenceLayer::class => object(RedBeanPersistenceLayer::class),

    /* App base configuration */
    'app.baseDir' => __DIR__ . '/../..',
    'app.cacheDir' => string('{app.baseDir}/cache'),
    'app.docsDir' => string('{app.baseDir}/docs'),
    'app.logsDir' => string('{app.baseDir}/logs'),
    'app.srcDir' => string('{app.baseDir}/src'),
    'app.storageDir' => string('{app.baseDir}/storage'),

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
