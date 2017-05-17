<?php

namespace RJ\PronosticApp\App;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use RJ\PronosticApp\App\Middleware\AuthenticationMiddleware;
use RJ\PronosticApp\App\Middleware\PersistenceMiddleware;
use RJ\PronosticApp\Controller\CommunityController;
use RJ\PronosticApp\Controller\PlayerController;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Persistence\AbstractPersistenceLayer;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\CommunityRepository;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\ParticipantRepository;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\PlayerRepository;
use RJ\PronosticApp\Persistence\PersistenceRedBean\RedBeanPersistenceLayer;
use RJ\PronosticApp\Util\Validation\GeneralValidator;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\Fractal\FractalGenerator;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;
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
    }

    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions(__DIR__ . '/../../configuration/config-security.php');
        $builder->addDefinitions(__DIR__ . '/../../configuration/config-app.php');
    }

    protected function configureRoutes()
    {
        $this->add($this->getContainer()->get(PersistenceMiddleware::class));

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
    }
}
