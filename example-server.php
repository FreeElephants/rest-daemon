<?php
require __DIR__ . '/vendor/autoload.php';

use FreeElephants\RestDaemon\BaseEndpoint;
use FreeElephants\RestDaemon\CallableEndpointMethodHandlerWrapper;
use FreeElephants\RestDaemon\ExceptionHandler\JsonExceptionHandler;
use FreeElephants\RestDaemon\RestServer;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

$server = new RestServer();
$server->setExceptionHandler(new JsonExceptionHandler());

$indexEndpoint = new BaseEndpoint('/', 'Index Endpoint');
$indexEndpoint->setMethodHandler('GET',
    new CallableEndpointMethodHandlerWrapper(function (RequestInterface $request): Response {
        $response = new Response(200);
        return $response;
    }));

$greetingEndpoint = new BaseEndpoint('/greeting', 'Root Resource');
$greetingEndpoint->setMethodHandler('GET',
    new CallableEndpointMethodHandlerWrapper(function (RequestInterface $request) {
        $response = new Response(200);
        $name = $request->getQuery()->get('name') ?: 'World';
        $response->setBody('{
            "hello": "' . $name . '!",
            "is_root_resource": true
        }');
        return $response;
    })
);

$exceptionThrowsEndpoint = new BaseEndpoint('/exception');
$exceptionThrowsEndpoint->setMethodHandler('GET',
    new CallableEndpointMethodHandlerWrapper(function (RequestInterface $request) {
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