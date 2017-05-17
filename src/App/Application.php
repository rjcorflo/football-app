<?php

namespace RJ\PronosticApp\App;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use RJ\PronosticApp\App\Middleware\AuthenticationMiddleware;
use RJ\PronosticApp\App\Middleware\PersistenceMiddleware;
use RJ\PronosticApp\Controller\CommunityController;
use RJ\PronosticApp\Controller\DocumentationController;
use RJ\PronosticApp\Controller\PlayerController;
use function DI\string;

class Application extends App
{
    public function __construct()
    {
        parent::__construct();

        $this->bootstrap();
    }

    protected function bootstrap()
    {
        $this->configureRoutes();
    }

    protected function configureContainer(ContainerBuilder $builder)
    {
        /* App paths configuration */
        $builder->addDefinitions([
            'app.baseDir' => __DIR__ . '/../..',
            'app.cacheDir' => string('{app.baseDir}/cache'),
            'app.docsDir' => string('{app.baseDir}/docs'),
            'app.logsDir' => string('{app.baseDir}/logs'),
            'app.srcDir' => string('{app.baseDir}/src'),
            'app.storageDir' => string('{app.baseDir}/storage'),
        ]);

        /* Security definitions */
        $builder->addDefinitions(__DIR__ . '/../../configuration/container/config-security.php');

        /* App definitions */
        $builder->addDefinitions(__DIR__ . '/../../configuration/container/config-app.php');
    }

    protected function configureRoutes()
    {
        $this->group('/api/v1', function () {
            $this->get('/doc/swagger', [DocumentationController::class, 'documentationSwagger']);

            $this->post('/player/register', [PlayerController::class, 'register']);
            $this->post('/player/login', [PlayerController::class, 'login']);

            $this->group('/player', function () {
                $this->post('/logout', [PlayerController::class, 'logout']);
                $this->get('/info', [PlayerController::class, 'info']);
            })->add(AuthenticationMiddleware::class);

            $this->group('/community', function () {
                $this->post('/create', [CommunityController::class, 'create']);
                $this->get('/{idCommunity:[0-9]+}/players', [CommunityController::class, 'communityPlayers']);
            })->add(AuthenticationMiddleware::class);
        })->add(PersistenceMiddleware::class);
    }
}
