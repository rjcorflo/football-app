<?php

namespace RJ\PronosticApp\App;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use RJ\PronosticApp\App\Middleware\AuthenticationMiddleware;
use RJ\PronosticApp\App\Middleware\InitializationMiddleware;
use RJ\PronosticApp\App\Middleware\PersistenceMiddleware;
use RJ\PronosticApp\Controller\CommunityController;
use RJ\PronosticApp\Controller\DocumentationController;
use RJ\PronosticApp\Controller\FixturesController;
use RJ\PronosticApp\Controller\ImagesController;
use RJ\PronosticApp\Controller\PlayerController;
use RJ\PronosticApp\Controller\PlayerLoginController;
use RJ\PronosticApp\Controller\PrivateCommunityController;
use RJ\PronosticApp\Controller\PublicCommunityController;
use function DI\string;

/**
 * Main class Application.
 *
 * @package RJ\PronosticApp\App
 */
class Application extends App
{
    /**
     * Application constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->bootstrap();
    }

    /**
     * Bootstrap method for application.
     */
    protected function bootstrap()
    {
        $this->configureRoutes();
    }

    /**
     * Configure dependency container.
     *
     * @param ContainerBuilder $builder
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        /* App paths configuration */
        $builder->addDefinitions([
            'app.baseDir' => __DIR__ . '/../..',
            'app.cacheDir' => string('{app.baseDir}/cache'),
            'app.configDir' => string('{app.baseDir}/configuration'),
            'app.docsDir' => string('{app.baseDir}/docs'),
            'app.logsDir' => string('{app.baseDir}/logs'),
            'app.srcDir' => string('{app.baseDir}/src'),
            'app.storageDir' => string('{app.baseDir}/storage'),
        ]);

        /* Security definitions */
        $builder->addDefinitions(__DIR__ . '/../../configuration/configuration.php');

        /* App definitions */
        $builder->addDefinitions(__DIR__ . '/DependencyInjection/definitions/di.app.php');
    }

    /**
     * Configure app routes.
     */
    protected function configureRoutes()
    {
        $this->group('/api/v1', function () {
            /* Documentation */
            $this->get('/doc/swagger', [DocumentationController::class, 'documentationSwagger']);

            /* Fixtures */
            $this->get('/fixtures/images', [FixturesController::class, 'fixturesImages']);

            /* Player */
            $this->post('/player/register', [PlayerLoginController::class, 'register']);
            $this->post('/player/login', [PlayerLoginController::class, 'login']);
            $this->post('/player/exist', [PlayerLoginController::class, 'exist']);

            $this->group('/player', function () {
                $this->post('/logout', [PlayerLoginController::class, 'logout']);
                $this->get('/info', [PlayerController::class, 'info']);
                $this->post('/communities', [PlayerController::class, 'listPlayerCommunities']);
            })->add(AuthenticationMiddleware::class);

            /* Images */
            $this->get('/images/list', [ImagesController::class, 'list']);

            /* Community */
            $this->group('/community', function () {
                $this->post('/create', [CommunityController::class, 'create']);
                $this->get('/{idCommunity:[0-9]+}/players', [CommunityController::class, 'communityPlayers']);
                $this->get('/search', [CommunityController::class, 'search']);
                $this->post('/exist', [CommunityController::class, 'exist']);

                $this->group('/private', function () {
                    $this->post('/join', [PrivateCommunityController::class, 'join']);
                });

                $this->group('/public', function () {
                    $this->get('/list', [PublicCommunityController::class, 'list']);
                    $this->post('/join', [PublicCommunityController::class, 'join']);
                });
            })->add(AuthenticationMiddleware::class);
        })->add(PersistenceMiddleware::class)
          ->add(InitializationMiddleware::class);
    }
}
