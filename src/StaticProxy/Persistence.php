<?php

namespace RJ\PronosticApp\StaticProxy;

/**
 * Persistence Layer StaticProxy.
 *
 * @method static getRepository(string $entityClass)
 * @method static persist($entity)
 * @method static flush()
 */
class Persistence extends StaticProxy
{
    protected static function getServiceAccessor()
    {
        return 'persistence';
    }
}
