<?php
/**
 * Bootstrap PSR-11 container and return it.
 *
 * Must return application in keys 'app' and '\Slim\App::class' as alias of 'app'.
 */

use RJ\PronosticApp\App\Application;
use RJ\PronosticApp\StaticProxy\StaticProxy;

/* *********************************************** */
/* *        Register Service Providers           * */
/* *********************************************** */
// Register service providers for applications
Application::registerServiceProviders([
    \RJ\PronosticApp\Provider\SettingsProvider::class,
    \RJ\PronosticApp\Provider\LoggerProvider::class,
    \RJ\PronosticApp\Provider\DoctrineProvider::class,
    \RJ\PronosticApp\Provider\MiddlewareProvider::class
]);

// Instantiate the app
$app = new Application();

/* *********************************************** */
/* *        Register Global Middlewares          * */
/* *********************************************** */
// Register global application middlewares
// Acts as LIFO queue, last added midleware is processed first
$app->registerMiddlewares([
    \Tuupola\Middleware\Cors::class,
    \Gofabian\Negotiation\NegotiationMiddleware::class
]);

/* *********************************************** */
/* *               Register Routes               * */
/* *********************************************** */
// Register routes
//$app->registerRoutes([
//    \USaq\Routes\PlayerRoutes::class
//]);

// Register routes on /api urls
$app->registerApiRoutes([
    \RJ\PronosticApp\Routes\Api\PlayerRoutes::class
]);

// Prepare Static Proxies
StaticProxy::setStaticProxyApplication($app);

return $app->getContainer();