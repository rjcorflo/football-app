<?php

namespace RJ\PronosticApp\App;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use RJ\PronosticApp\App\Controller\CommunityController;
use RJ\PronosticApp\App\Controller\DocumentationController;
use RJ\PronosticApp\App\Controller\ForecastController;
use RJ\PronosticApp\App\Controller\ImagesController;
use RJ\PronosticApp\App\Controller\MatchController;
use RJ\PronosticApp\App\Controller\PlayerController;
use RJ\PronosticApp\App\Controller\PlayerLoginController;
use RJ\PronosticApp\App\Controller\PrivateCommunityController;
use RJ\PronosticApp\App\Controller\PublicCommunityController;
use RJ\PronosticApp\App\Event\AppBootstrapEvent;
use RJ\PronosticApp\App\Middleware\AuthenticationMiddleware;
use RJ\PronosticApp\App\Middleware\InitializationMiddleware;
use RJ\PronosticApp\App\Middleware\PersistenceMiddleware;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use function DI\string;

/**
 * Main class Application.
 *
 * @package RJ\PronosticApp\App
 */
class Application extends App
{
    /**
     * @var array
     */
    protected $modules = [
        ['active' => false, 'class' => '\RJ\PronosticApp\Module\FootballData\FootballDataModule'],
        ['active' => true, 'class' => '\RJ\PronosticApp\Module\Updater\UpdaterModule']
    ];

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

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
        $this->configureModulesEventDispatcher();
        $this->configureRoutes();

        $this->dispatcher->dispatch(AppBootstrapEvent::NAME, new AppBootstrapEvent($this));
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

        foreach ($this->modules as $module) {
            if ($module['active']) {
                $interfaces = class_implements($module['class']);

                if (isset($interfaces['RJ\PronosticApp\Module\ServiceProvider'])) {
                    $builder->addDefinitions(call_user_func("{$module['class']}::getDependencyInjectionDefinitions"));
                }
            }
        }
    }

    /**
     * Subscribe modules to event dispatcher if they are active.
     */
    protected function configureModulesEventDispatcher()
    {
        $this->dispatcher = $this->getContainer()->get(EventDispatcherInterface::class);

        foreach ($this->modules as $module) {
            if ($module['active']) {
                $this->dispatcher->addSubscriber($this->getContainer()->get($module['class']));
            }
        }
    }

    /**
     * Configure app routes.
     */
    protected function configureRoutes()
    {
        $this->group('/api/v1', function () {
            /* Documentation */
            $this->get('/doc/swagger', [DocumentationController::class, 'documentationSwagger']);

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
                $this->post('/{idCommunity:[0-9]+}/data', [CommunityController::class, 'communityData']);
                $this->post('/{idCommunity:[0-9]+}/forecast', [ForecastController::class, 'saveForecasts']);
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

            /* Match */
            $this->group('/match', function () {
                $this->post('/actives', [MatchController::class, 'activeMatches']);
            })->add(AuthenticationMiddleware::class);
        })->add(PersistenceMiddleware::class)
          ->add(InitializationMiddleware::class);
    }
}
