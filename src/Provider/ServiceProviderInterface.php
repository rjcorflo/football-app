<?php

namespace RJ\PronosticApp\Provider;

/**
 * Interface ServiceProviderInterface.
 *
 * All classes that provides services must implements this interface.
 */
interface ServiceProviderInterface
{
    /**
     * Register services on PHP-DI container.
     *
     * @return array
     */
    public function registerServices(): array;

    /**
     * Register services on PHP-DI when APP_ENV=development.
     *
     * Can be use to replace specifics service definitions when developing.
     *
     * @return array
     */
    public function registerServicesDevelopment(): array;

    /**
     * Register services on PHP-DI when APP_ENV=test
     *
     * Can be use to replace specifics services definitions when developing.
     *
     * @return array
     */
    public function registerServicesTest(): array;
}
