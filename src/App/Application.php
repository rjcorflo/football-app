<?php

namespace RJ\FootballApp\App;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Persistence\RedBeanPersistence\RedBeanPersistenceLayer;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use RJ\FootballApp\Aspect\ApplicationAspect;
use RJ\FootballApp\Aspect\LoggerAspect;
use RJ\FootballApp\Controller\PlayerController;
use RJ\FootballApp\Persistence\AbstractPersistenceLayer;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use function DI\get;
use function DI\object;
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

        /**
         * @var \Go\Core\AspectKernel $aspectApp
         */
        $aspectApp = $this->getContainer()->get('aop.app');
        $aspectApp->init([
            'debug' => true,
            'cacheDir' => $this->getContainer()->get('app.cacheDir') . '/aop',
            'includePaths' => [
                $this->getContainer()->get('app.srcDir')
            ]
        ]);
    }

    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions(__DIR__ . '/../../configuration/configuration.php');
        $builder->addDefinitions($this->configuration());
    }

    private function configuration()
    {
        return [
            /* Slim configuration */
            'settings.displayErrorDetails' => true,

            /* Middleware */
            AbstractPersistenceLayer::class => object(RedBeanPersistenceLayer::class),

            /* App base configuration */
            'app.baseDir' => __DIR__ . '/../..',
            'app.cacheDir' => string('{app.baseDir}/cache'),
            'app.logsDir' => string('{app.baseDir}/logs'),
            'app.srcDir' => string('{app.baseDir}/src'),
            'app.storageDir' => string('{app.baseDir}/storage'),

            /* Event configuration */
            EventDispatcherInterface::class => object(EventDispatcher::class),

            /* Logger configuration */
            StreamHandler::class => object()->constructor(string('{app.logsDir}/logs.log')),
            'logger.handlers' => [
                get(StreamHandler::class)
            ],
            LoggerInterface::class => function (ContainerInterface $container) {
                $logger = new Logger('logger');
                foreach ($container->get('logger.handlers') as $handlers) {
                    $logger->pushHandler($handlers);
                }
                return $logger;
            },

            /* Aspects configuration */
            'aop.aspects' => [
                get(LoggerAspect::class)
            ],
            'aop.app' => function (ContainerInterface $containerInterface) {
                $appAop = ApplicationAspect::getInstance();
                $appAop->setContainer($containerInterface);
                return $appAop;
            }
        ];
    }

    protected function configureRoutes()
    {
        $this->get('/player/register', [PlayerController::class, 'register'])
            ->add($this->getContainer()->get(AbstractPersistenceLayer::class));

        $this->get('/player/login', [PlayerController::class, 'login']);
        $this->get('/player/logout', [PlayerController::class, 'logout']);
    }
}
