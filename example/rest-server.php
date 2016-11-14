<?php
require __DIR__ . '/../vendor/autoload.php';

use FreeElephants\RestDaemon\BaseEndpoint;
use FreeElephants\RestDaemon\CallableEndpointMethodHandlerWrapper;
use FreeElephants\RestDaemon\Middleware\DefaultEndpointMiddlewareCollection;
use FreeElephants\RestDaemon\RestServer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$server = new RestServer();
$accessLogger = new Logger('access', [new StreamHandler('php://stdout')]);
$server->setMiddlewareCollection(new DefaultEndpointMiddlewareCollection([], [
    function (
        RequestInterface $request,
        ResponseInterface $response,
        callable $next
    ) {
        static $requestNumber = 0;
        printf('[%s] request number #%d handled' . PHP_EOL, date(DATE_ISO8601), ++$requestNumber);
        return $next($request, $response);
    }
]));

$indexEndpoint = new BaseEndpoint('/', 'Index Endpoint');
$indexEndpoint->setMethodHandler('GET',
    new CallableEndpointMethodHandlerWrapper(function (
        RequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        $response = $response->withStatus(200);
        return $next($request, $response);
    }));

$greetingEndpoint = new BaseEndpoint('/greeting', 'Some Resource');
$greetingEndpoint->setMethodHandler('GET',
    new CallableEndpointMethodHandlerWrapper(function (RequestInterface $request, ResponseInterface $response, $next) {
        parse_str($request->getUri()->getQuery(), $params);
        $name = array_key_exists('name', $params) ? $params['name'] : 'World';
        $response->getBody()->write('{
            "hello": "' . $name . '!"
        }');
        return $next($request, $response);
    })
);
$greetingEndpoint->setMethodHandler('POST',
    new CallableEndpointMethodHandlerWrapper(function (ServerRequestInterface $request, ResponseInterface $response, $next) {
        parse_str($request->getBody()->getContents(), $params);
        $name = array_key_exists('name', $params) ? $params['name'] : 'World';
        $response->getBody()->write('{
            "hello": "' . $name . '!"
        }');
        return $next($request, $response);
    })
);

$exceptionThrowsEndpoint = new BaseEndpoint('/exception');
$exceptionThrowsEndpoint->setMethodHandler('GET',
    new CallableEndpointMethodHandlerWrapper(function (RequestInterface $request, ResponseInterface $response) {
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