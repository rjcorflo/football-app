<?php

namespace RJ\PronosticApp\Provider;

use function DI\get;
use function DI\object;
use function DI\string;

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
            'errorHandler' => \DI\object(\RJ\PronosticApp\App\Handlers\ErrorHandler::class)
                ->constructor(\DI\get('settings.displayErrorDetails'), get(WebResourceGeneratorInterface::class)),
            'phpErrorHandler' => \DI\object(\RJ\PronosticApp\App\Handlers\PhpErrorHandler::class)
                ->constructor(\DI\get('settings.displayErrorDetails'), get(WebResourceGeneratorInterface::class)),
            'notFoundHandler' => \DI\object(\RJ\PronosticApp\App\Handlers\NotFoundHandler::class),
            'notAllowedHandler' => \DI\object(\RJ\PronosticApp\App\Handlers\NotAllowedHandler::class),
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
