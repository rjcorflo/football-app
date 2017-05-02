<?php

namespace RJ\FootballApp\App;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use RJ\FootballApp\Controller\UserController;

use function DI\object;
use function DI\get;

class Application extends App
{
    public function __construct()
    {
        parent::__construct();

        $this->initialize();
    }

    private function initialize()
    {
        $this->routes();
    }

    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions($this->configuration());
    }

    private function configuration()
    {
        return [
            'settings.displayErrorDetails' => true,
            //'foundHandler' => \DI\object(RequestResponse::class)
        ];
    }

    private function routes()
    {
        $this->get('/login', [UserController::class, 'login']);
        $this->get('/logout', [UserController::class, 'logout']);
    }
}
