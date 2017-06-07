<?php

namespace RJ\PronosticApp\App\Event;

use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\App\Application;
use Symfony\Component\EventDispatcher\Event;

/**
 * Initialization event.
 *
 * @package RJ\PronosticApp\Event
 */
class AppBootstrapEvent extends Event
{
    const NAME = 'app.bootstrap';

    /**
     * @var Application
     */
    private $app;

    /**
     * AppBootstrapEvent constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return Application
     */
    public function getApp(): Application
    {
        return $this->app;
    }
}
