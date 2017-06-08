<?php

namespace RJ\PronosticApp\Module\Updater;

use RJ\PronosticApp\App\Event\AppBootstrapEvent;
use RJ\PronosticApp\App\Middleware\InitializationMiddleware;
use RJ\PronosticApp\App\Middleware\PersistenceMiddleware;
use RJ\PronosticApp\Module\AbstractModule;
use RJ\PronosticApp\Module\Updater\Controller\UpdateController;

/**
 * Class UpdaterModule.
 *
 * Module to provide default data.
 *
 * @package RJ\PronosticApp\Module\Updater
 */
class UpdaterModule extends AbstractModule
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
     * @param AppBootstrapEvent $event
     */
    public function bootstrap(AppBootstrapEvent $event)
    {
        $app = $event->getApp();

        $app->group('/api/v1', function () use ($app) {
            $app->get('/update/all', [UpdateController::class, 'updateAll']);
        })->add(PersistenceMiddleware::class)
          ->add(InitializationMiddleware::class);
    }
}
