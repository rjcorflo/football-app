<?php

namespace RJ\PronosticApp\Routes\Api;

use RJ\PronosticApp\App\Application;
use RJ\PronosticApp\Middleware\AuthenticationMiddleware;
use RJ\PronosticApp\Routes\RoutesProviderInterface;

/**
 * Provide routes for User resource.
 */
class PlayerRoutes implements RoutesProviderInterface
{
    /**
     * @inheritdoc
     */
    public function registerRoutes(Application $app): void
    {
        /* Player */
        $app->post('/player/register', [PlayerLoginController::class, 'register']);
        $app->post('/player/login', [PlayerLoginController::class, 'login']);
        $app->post('/player/exist', [PlayerLoginController::class, 'exist']);

        $app->group('/player', function () use ($app) {
            $app->post('/logout', [PlayerLoginController::class, 'logout']);
            $app->get('/info', [PlayerController::class, 'info']);
            $app->post('/communities', [PlayerController::class, 'listPlayerCommunities']);
        })->add(AuthenticationMiddleware::class);
    }
}
