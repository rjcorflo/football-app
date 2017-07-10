<?php

namespace RJ\PronosticApp\StaticProxy;

use Psr\Container\ContainerInterface;

/**
 * Container StaticProxy.
 *
 * @method static mixed get($id)
 * @method static bool has($id)
 */
class Container extends StaticProxy
{
    /**
     * @return ContainerInterface
     */
    protected static function getServiceAccessor()
    {
        return static::$app->getContainer();
    }
}
