<?php

namespace RJ\PronosticApp\Module;

/**
 * Modules that provides dependency injection definitions must implement this interface.
 *
 * @package RJ\PronosticApp\Module
 */
interface ServiceProvider
{
    /**
     * Must return array with DDI definitions for this module.
     *
     * @return array
     */
    public static function getDependencyInjectionDefinitions(): array;
}
