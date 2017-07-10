<?php

namespace RJ\PronosticApp\StaticProxy;

use Slim\App;

/**
 * Class StaticProxy.
 *
 * All new static proxies must extend this abstract class.
 */
abstract class StaticProxy
{
    /**
     * The application instance being proxied.
     *
     * @var App
     */
    protected static $app;

    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static $resolvedInstance;

    /**
     * Get the root object behind the static proxy.
     *
     * @return mixed
     */
    public static function getStaticProxyRoot()
    {
        return static::resolveServiceInstance(static::getServiceAccessor());
    }

    /**
     * Get the registered name of the component.
     *
     * @return mixed
     *
     * @throws \RuntimeException
     */
    protected static function getServiceAccessor()
    {
        throw new \RuntimeException('StaticProxy does not implement getServiceAccessor method.');
    }

    /**
     * Resolve the proxy root instance from the container.
     *
     * @param  string|object  $name
     * @return mixed
     */
    private static function resolveServiceInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        return static::$resolvedInstance[$name] = static::$app->getContainer()->get($name);
    }

    /**
     * Clear a resolved service instance.
     *
     * @param  string  $name
     * @return void
     */
    public static function clearResolvedInstance($name)
    {
        unset(static::$resolvedInstance[$name]);
    }

    /**
     * Clear all of the resolved instances.
     *
     * @return void
     */
    public static function clearResolvedInstances()
    {
        static::$resolvedInstance = [];
    }

    /**
     * Get the application instance behind the proxy.
     *
     * @return App
     */
    public static function getStaticProxyApplication()
    {
        return static::$app;
    }

    /**
     * Set the application instance.
     *
     * @param  App  $app
     * @return void
     */
    public static function setStaticProxyApplication(App $app)
    {
        static::$app = $app;
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array   $args
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getStaticProxyRoot();

        if (!$instance) {
            throw new \RuntimeException('A static proxy root has not been set.');
        }

        return $instance->$method(...$args);
    }
}
