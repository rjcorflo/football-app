<?php
/**
 * Created by IntelliJ IDEA.
 * User: RJ Corchero
 * Date: 10/07/2017
 * Time: 21:14
 */

namespace RJ\PronosticApp\Routes\Api;


use RJ\PronosticApp\App\Application;
use RJ\PronosticApp\App\Controller\ClassificationController;
use RJ\PronosticApp\App\Controller\ImagesController;
use RJ\PronosticApp\App\Controller\UtilController;
use RJ\PronosticApp\Routes\RoutesProviderInterface;

class OtherRoutes implements RoutesProviderInterface
{
    /**
     * @inheritDoc
     */
    public function registerRoutes(Application $app): void
    {
        /* Images */
        $app->get('/images/list', [ImagesController::class, 'list']);

        /* Classifications */
        $app->group('/classification', function () use ($app) {
            $app->get('/calculate', [ClassificationController::class, 'calculateClassifications']);
        });

        /* Utils */
        $app->group('/util', function () use ($app) {
            $app->map(['GET', 'POST'], '/date', [UtilController::class, 'serverDate']);
        });
    }

}