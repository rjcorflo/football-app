<?php

namespace RJ\App;

use Doctrine\Common\Annotations\AnnotationReader;
use RJ\FootballApp\App\Middleware\PersistenceMiddleware;
use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use RJ\FootballApp\Aspect\ApplicationAspect;
use RJ\FootballApp\Aspect\LoggerAspect;
use RJ\FootballApp\Controller\PlayerController;
use RJ\FootballApp\Model\Repository\PlayerRepositoryInterface;
use RJ\FootballApp\Persistence\AbstractPersistenceLayer;
use RJ\FootballApp\Persistence\RedBeanPersistence\Model\Repository\PlayerRepository;
use RJ\FootballApp\Persistence\RedBeanPersistence\RedBeanPersistenceLayer;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use function DI\get;
use function DI\object;
use function DI\string;
use WebResource\Fractal\FractalGenerator;
use WebResource\WebResourceGeneratorInterface;

class Application extends App
{
    public function __construct()
    {
        parent::__construct();

        $this->bootstrap();
    }

    protected function bootstrap()
    {
        AnnotationReader::addGlobalIgnoredName('note');
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

            PlayerRepositoryInterface::class => object(PlayerRepository::class),
            WebResourceGeneratorInterface::class => object(FractalGenerator::class),

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
        $this->add($this->getContainer()->get(PersistenceMiddleware::class));

        $this->post('/player/register', [PlayerController::class, 'register']);
        $this->get('/player/login', [PlayerController::class, 'login']);
        $this->get('/player/logout', [PlayerController::class, 'logout']);
        $this->get('/player/all', [PlayerController::class, 'getAll']);
    }
}
