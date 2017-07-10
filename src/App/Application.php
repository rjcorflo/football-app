<?php

namespace RJ\PronosticApp\App;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\App\Controller\ClassificationController;
use RJ\PronosticApp\App\Controller\ImagesController;
use RJ\PronosticApp\App\Controller\UtilController;
use RJ\PronosticApp\App\Event\AppBootstrapEvent;
use RJ\PronosticApp\Middleware\InitializationMiddleware;
use RJ\PronosticApp\Provider\ServiceProviderInterface;
use RJ\PronosticApp\Routes\RoutesProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Main class Application.
 *
 * @package RJ\PronosticApp\App
 */
class Application extends App
{
    /**
     * @var string[]
     */
    protected static $serviceProviders;

    /**
     * @var string[]
     */
    protected $modules;

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
     * Subscribe modules to event dispatcher if they are active.
     */
    protected function configureModulesEventDispatcher()
    {
        $this->dispatcher = $this->getContainer()->get(EventDispatcherInterface::class);

        foreach ($this->modules as $module) {
            $this->dispatcher->addSubscriber($this->getContainer()->get($module));
        }
    }

    /**
     * Register applications ServiceProviders for dependency container.
     *
     * @param string[] $serviceProviders
     */
    public static function registerServiceProviders(array $serviceProviders)
    {
        static::$serviceProviders = $serviceProviders;
    }

    /**
     * Configure dependency container.
     *
     * @param ContainerBuilder $builder
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        $environment = getenv('APP_ENV');

        // Add caching for definitions
        if ($environment !== 'production') {
            $builder->setDefinitionCache(new ArrayCache());
        } else {
            $builder->setDefinitionCache(new FilesystemCache(__DIR__ . '/../../cache/container'));
        }

        foreach (static::$serviceProviders as $serviceProviderClassName) {
            $serviceProvider = new $serviceProviderClassName();

            if (!$serviceProvider instanceof ServiceProviderInterface) {
                throw new \RuntimeException('Not implements ServiceProvider interface');
            }

            $builder->addDefinitions($serviceProvider->registerServices());

            if ($environment == 'development') {
                $builder->addDefinitions($serviceProvider->registerServicesDevelopment());
            } elseif ($environment == 'test') {
                $builder->addDefinitions($serviceProvider->registerServicesTest());
            }
        }

        foreach ($this->modules as $module) {
            if ($module['active']) {
                $interfaces = class_implements($module['class']);

                if (isset($interfaces['RJ\PronosticApp\Module\ServiceProvider'])) {
                    $builder->addDefinitions(call_user_func("{$module['class']}::getDependencyInjectionDefinitions"));
                }
            }
        }

        $builder->addDefinitions([
            'app' => function (ContainerInterface $c) {
                return $this;
            },
            \Slim\App::class => \DI\get('app')
        ]);
    }

    /**
     * Register application global middlewares.
     *
     * Middlewares acts as LIFO queue.
     *
     * @param mixed[] $middlewares
     */
    public function registerMiddlewares(array $middlewares)
    {
        foreach ($middlewares as $middleware) {
            if (!is_callable($middleware) && !is_string($middleware)) {
                throw new \RuntimeException('Not a callable or string for container');
            }

            $this->add($middleware);
        }
    }

    /**
     * Register routes.
     *
     * @param string[] $routesProviders
     */
    public function registerRoutes(array $routesProviders)
    {
        foreach ($routesProviders as $routeProviderClassName) {
            $routeProvider = new $routeProviderClassName();
            if (!$routeProvider instanceof RoutesProviderInterface) {
                throw new \RuntimeException('Not implements RoutesProviderInterface');
            }

            $routeProvider->registerRoutes($this);
        }
    }

    /**
     * Register api routes.
     *
     * @param string[] $routesProviders
     */
    public function registerApiRoutes(array $routesProviders)
    {
        $this->group('/api/v1', function () use ($routesProviders) {
            $this->registerRoutes($routesProviders);
        });
    }

    /**
     * Configure app routes.
     */
    protected function configureRoutes()
    {
        $this->group('/api/v1', function () {

            /* Images */
            $this->get('/images/list', [ImagesController::class, 'list']);

            /* Classifications */
            $this->group('/classification', function () {
                $this->get('/calculate', [ClassificationController::class, 'calculateClassifications']);
            });


            /* Utils */
            $this->group('/util', function () {
                $this->map(['GET', 'POST'], '/date', [UtilController::class, 'serverDate']);
            });
        })->add(InitializationMiddleware::class);
    }
}
