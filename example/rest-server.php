<?php
require __DIR__ . '/../vendor/autoload.php';

use FreeElephants\RestDaemon\Endpoint\BaseEndpoint;
use FreeElephants\RestDaemon\Endpoint\CallableEndpointMethodHandlerWrapper;
use FreeElephants\RestDaemon\Middleware\Collection\DefaultEndpointMiddlewareCollection;
use FreeElephants\RestDaemon\RestServer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RestDeamon\Example\Endpoint\Greeting\GetHandler as GreetingGetHandler;
use RestDeamon\Example\Endpoint\Greeting\PostHandler;
use RestDeamon\Example\Endpoint\Index\GetHandler;

$httpDriverClass = \FreeElephants\RestDaemon\HttpDriver\Aerys\AerysDriver::class;
$server = new RestServer('127.0.0.1', 8080, '0.0.0.0', ['*']);

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

$indexEndpoint = new BaseEndpoint('/', 'Index Endpoint');
$indexEndpoint->setMethodHandler('GET', new GetHandler());

$greetingEndpoint = new BaseEndpoint('/greeting', 'Some Resource');
$greetingEndpoint->setMethodHandler('GET', new GreetingGetHandler());
$greetingEndpoint->setMethodHandler('POST', new PostHandler());

$exceptionThrowsEndpoint = new BaseEndpoint('/exception');
$exceptionThrowsEndpoint->setMethodHandler('GET',
    new CallableEndpointMethodHandlerWrapper(function () {
        throw new \LogicException("Logic exception");
    })
);

$server->addEndpoint($indexEndpoint);
$server->addEndpoint($greetingEndpoint);
$server->addEndpoint($exceptionThrowsEndpoint);
/**
 * Note: after server will be run, php script going to loop and code after this line not be executed.
 */
$server->run();
