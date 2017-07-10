<?php

namespace RJ\PronosticApp\Routes;

use RJ\PronosticApp\App\Application;

/**
 * Interface RoutesProviderInterface.
 *
 * All classes that provides routes must implements this interface.
 */
interface RoutesProviderInterface
{
    /**
     * Register new routes.
     *
     * @param Application $app
     * @return void
     */
    public function registerRoutes(Application $app): void;
}
