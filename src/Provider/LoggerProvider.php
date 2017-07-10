<?php

namespace RJ\PronosticApp\Provider;

use function DI\get;
use function DI\object;
use function DI\string;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Provide logger service configuration.
 */
class LoggerProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function registerServices(): array
    {
        return [
            /* Logger configuration */
            'logger.max-log-files' => 20,

            StreamHandler::class => object()->constructor(string('{dir.logs}/logs.log')),
            RotatingFileHandler::class => object()->constructor(string('{dir.logs}/logger.log'), get('logger.max-log-files')),

            'logger.handlers' => [
                get(RotatingFileHandler::class)
            ],

            'logger' => get(LoggerInterface::class),

            LoggerInterface::class => function (ContainerInterface $container) {
                $logger = new Logger('REQUEST');
                foreach ($container->get('logger.handlers') as $handlers) {
                    $logger->pushHandler($handlers);
                }
                $logger->pushProcessor(new PsrLogMessageProcessor());

                return $logger;
            }
        ];
    }

    /**
     * @inheritdoc
     */
    public function registerServicesDevelopment(): array
    {
        return [
            /* Logger Dev configuration */
            StreamHandler::class => object()->constructor(string('{dir.logs}/logs-dev.log')),
            RotatingFileHandler::class => object()->constructor(string('{dir.logs}/logger-dev.log'), get('logger.max-log-files'))
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
