<?php

namespace RJ\PronosticApp\Routes\Api;

use RJ\PronosticApp\App\Application;
use RJ\PronosticApp\App\Controller\CommunityController;
use RJ\PronosticApp\App\Controller\ForecastController;
use RJ\PronosticApp\App\Controller\MatchController;
use RJ\PronosticApp\App\Controller\PrivateCommunityController;
use RJ\PronosticApp\App\Controller\PublicCommunityController;
use RJ\PronosticApp\Middleware\AuthenticationMiddleware;
use RJ\PronosticApp\Routes\RoutesProviderInterface;

class CommunityRoutes implements RoutesProviderInterface
{
    /**
     * @inheritDoc
     */
    public function registerRoutes(Application $app): void
    {
        /* Community */
        $app->group('/community', function () use ($app) {
            $app->post('/create', [CommunityController::class, 'create']);
            $app->get('/{idCommunity:[0-9]+}/players', [CommunityController::class, 'communityPlayers']);
            $app->post('/{idCommunity:[0-9]+}/data', [CommunityController::class, 'communityData']);
            $app->post(
                '/{idCommunity:[0-9]+}/general',
                [CommunityController::class, 'communityGeneralClassification']
            );
            $app->post('/{idCommunity:[0-9]+}/forecast', [ForecastController::class, 'saveForecasts']);
            $app->post('/{idCommunity:[0-9]+}/matches/actives', [MatchController::class, 'activeMatches']);
            $app->get('/search', [CommunityController::class, 'search']);
            $app->post('/exist', [CommunityController::class, 'exist']);

            $app->group('/private', function () use ($app) {
                $app->post('/join', [PrivateCommunityController::class, 'join']);
            });

            $app->group('/public', function () use ($app) {
                $app->get('/list', [PublicCommunityController::class, 'list']);
                $app->post('/join', [PublicCommunityController::class, 'join']);
            });
        })->add(AuthenticationMiddleware::class);
    }
}