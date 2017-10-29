<?php
/**
 * Example of rest daemon server usage.
 *
 * Run this script: `php rest-server.php`
 *
 * This scrip uses for acceptance testing with codeception.
 *
 * @author samizdam <samizdam@inbox.ru>
 */

require __DIR__ . '/../vendor/autoload.php';

use FreeElephants\DI\InjectorBuilder;
use FreeElephants\RestDaemon\Middleware\Collection\DefaultEndpointMiddlewareCollection;
use FreeElephants\RestDaemon\RestServer;
use FreeElephants\RestDaemon\RestServerBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$httpDriverClass = getenv('DRIVER_CLASS') ?: RestServer::DEFAULT_HTTP_DRIVER;

$httpHost = '127.0.0.1';
$port = 8080;
$address = '0.0.0.0';
$origin = ['*'];

$routes = require __DIR__ . '/routes.php';
$components = require __DIR__ . '/components.php';
$injector = (new InjectorBuilder())->buildFromArray($components);
$server = new RestServer($httpHost, $port, $address, $origin);
$restServerBuilder = new RestServerBuilder($injector);
$restServerBuilder->setServer($server);
$restServerBuilder->buildServer($routes);

$requestCounter = function (
    ServerRequestInterface $request,
    ResponseInterface $response,
    callable $next
) {
    static $requestNumber = 0;
    printf('[%s] request number #%d handled' . PHP_EOL, date(DATE_ISO8601), ++$requestNumber);

    return $next($request, $response);
};
$extendedDefaultMiddlewareCollection = new DefaultEndpointMiddlewareCollection([], [$requestCounter]);
$server->setMiddlewareCollection($extendedDefaultMiddlewareCollection);

$server->run();
