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

use FreeElephants\RestDaemon\Endpoint\BaseEndpoint;
use FreeElephants\RestDaemon\Endpoint\CallableEndpointMethodHandlerWrapper;
use FreeElephants\RestDaemon\Middleware\Collection\DefaultEndpointMiddlewareCollection;
use FreeElephants\RestDaemon\Module\BaseApiModule;
use FreeElephants\RestDaemon\RestServer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RestDeamon\Example\Endpoint\Greeting\GetAttributeHandler;
use RestDeamon\Example\Endpoint\Greeting\GetHandler as GreetingGetHandler;
use RestDeamon\Example\Endpoint\Greeting\PostHandler;
use RestDeamon\Example\Endpoint\Index\GetHandler;
use RestDeamon\Example\Endpoint\Reusable\HelloHandler;

$httpDriverClass = getenv('DRIVER_CLASS') ?: RestServer::DEFAULT_HTTP_DRIVER;

$server = new RestServer('127.0.0.1', 8080, '0.0.0.0', ['*'], $httpDriverClass);

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

$greetingEndpoint = new BaseEndpoint('/greeting', 'Greeting by name in params');
$greetingEndpoint->setMethodHandler('GET', new GreetingGetHandler());
$greetingEndpoint->setMethodHandler('POST', new PostHandler());
$greetingAttributeEndpoint = new BaseEndpoint('/greeting/{name}', 'Greeting by name in path');
$greetingAttributeEndpoint->setMethodHandler('GET', new GetAttributeHandler());

$exceptionThrowsEndpoint = new BaseEndpoint('/exception');
$exceptionThrowsEndpoint->setMethodHandler('GET',
    new CallableEndpointMethodHandlerWrapper(function () {
        throw new \LogicException("Logic exception");
    })
);

$server->addEndpoint($indexEndpoint);
$server->addEndpoint($greetingEndpoint);
$server->addEndpoint($greetingAttributeEndpoint);
$server->addEndpoint($exceptionThrowsEndpoint);

/*
 * We can use modules for grouping endpoints.
 * Usually case: route based api versions.
 * $helloEndpoint_v1 path will be completed after addition to module with module base: /api/v1/hello
 */
$helloEndpoint_v1 = new BaseEndpoint('/hello', 'Hello World');
$helloEndpoint_v1->setMethodHandler('GET', new HelloHandler());
$module_v1 = new BaseApiModule('/api/v1', 'Api ver.1');
$module_v1->addEndpoint($helloEndpoint_v1);
$server->addModule($module_v1);

$helloEndpoint_v2 = new BaseEndpoint('/hello', 'Hello World');
$helloEndpoint_v2->setMethodHandler('GET', new HelloHandler());
$module_v2 = new BaseApiModule('/api/v2', 'Api ver.2');
$module_v2->addEndpoint($helloEndpoint_v2);
$server->addModule($module_v2);
/*
 * By default, rest server contain root module for directly added endpoints.
 */
$helloEndpointInTheRoot = new BaseEndpoint('/hello', 'Hello World');
$helloEndpointInTheRoot->setMethodHandler('GET', new HelloHandler());
$server->addEndpoint($helloEndpointInTheRoot);

/**
 * Note: after server will be run, php script going to loop and code after this line not be executed.
 */
$server->run();
