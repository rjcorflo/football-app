<?php

namespace RJ\PronosticApp\StaticProxy;

/**
 * App facade.
 *
 * @method static \Psr\Container\ContainerInterface getContainer()
 * @method static \Psr\Http\Message\ResponseInterface run($silent = false)
 */
class App extends StaticProxy
{
    /**
     * @return \Slim\App
     */
    protected static function getServiceAccessor()
    {
        return self::$app;
    }
}
