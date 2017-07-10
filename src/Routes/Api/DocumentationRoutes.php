<?php

namespace RJ\PronosticApp\Routes\Api;


use RJ\PronosticApp\App\Application;
use RJ\PronosticApp\Routes\RoutesProviderInterface;

class DocumentationRoutes implements RoutesProviderInterface
{
    /**
     * @inheritDoc
     */
    public function registerRoutes(Application $app): void
    {
        /* Documentation */
        $app->get('/doc/swagger', [DocumentationController::class, 'documentationSwagger']);
    }
}