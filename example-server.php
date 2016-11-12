<?php
require __DIR__ . '/vendor/autoload.php';

use FreeElephants\RestDaemon\BaseEndpoint;
use FreeElephants\RestDaemon\CallableEndpointMethodHandlerWrapper;
use FreeElephants\RestDaemon\RestServer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

$server = new RestServer();
$indexEndpoint = new BaseEndpoint('/', 'Index Endpoint');
$indexEndpoint->setMethodHandler('GET',
    new CallableEndpointMethodHandlerWrapper(function (
        RequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $response = $response->withStatus(200);
        return $response;
    }));

$greetingEndpoint = new BaseEndpoint('/greeting', 'Root Resource');
$greetingEndpoint->setMethodHandler('GET',
    new CallableEndpointMethodHandlerWrapper(function (RequestInterface $request, ResponseInterface $response) {
        parse_str($request->getUri()->getQuery(), $params);
        $name = array_key_exists('name', $params) ? $params['name'] : 'World';
        $response->getBody()->write('{
            "hello": "' . $name . '!",
            "is_root_resource": true
        }');
        return $response;
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
