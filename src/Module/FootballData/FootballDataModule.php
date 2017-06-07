<?php

namespace RJ\PronosticApp\Module\FootballData;

use GuzzleHttp\Client;
use RJ\PronosticApp\App\Event\AppBootstrapEvent;
use RJ\PronosticApp\App\Middleware\InitializationMiddleware;
use RJ\PronosticApp\App\Middleware\PersistenceMiddleware;
use RJ\PronosticApp\Module\AbstractModule;
use RJ\PronosticApp\Module\FootballData\Controller\TestController;
use RJ\PronosticApp\Module\FootballData\Service\FootballDataRetriever;
use RJ\PronosticApp\Module\FootballData\Service\HttpFootballDataRetriever;
use RJ\PronosticApp\Module\ServiceProvider;
use function DI\get;

/**
 * Module to retrieve dat from FootballApi
 *
 * @package RJ\PronosticApp\Module\FootballData
 */
class FootballDataModule extends AbstractModule implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            AppBootstrapEvent::NAME => [
                'bootstrap'
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getDependencyInjectionDefinitions(): array
    {
        return [
            FootballDataRetriever::class => function () {
                $client = new Client([
                    'base_uri' => 'http://api.football-data.org/v1/',
                    'headers' => [
                        'X-Auth-Token' => get('module.footballdata.apikey'),
                        'X-Response-Control' => 'full'
                    ]
                ]);

                return new HttpFootballDataRetriever($client);
            }
        ];
    }

    /**
     * @param AppBootstrapEvent $event
     */
    public function bootstrap(AppBootstrapEvent $event)
    {
        $app = $event->getApp();

        $app->group('/api/v1', function () use ($app) {
            $app->get('/test', [TestController::class, 'test']);
            $app->get('/test1', [TestController::class, 'test1']);
        })->add(PersistenceMiddleware::class)
            ->add(InitializationMiddleware::class);
    }
}
