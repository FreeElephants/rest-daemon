<?php
require __DIR__ . '/vendor/autoload.php';

use FreeElephants\RestDaemon\BaseEndpoint;
use FreeElephants\RestDaemon\CallableMethodHandlerWrapper;
use FreeElephants\RestDaemon\RestServer;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

$server = new RestServer();
$endpoint = new BaseEndpoint('/greeting', 'Root Resource');
$endpoint->setMethodHandler('GET', new CallableMethodHandlerWrapper(function (RequestInterface $request) {
    var_dump($request->getMethod());
        $response = new Response(200);
        $name = $request->getQuery()->get('name') ?: 'World';
        $response->setBody('{
            "hello": "' . $name . '!",
            "is_root_resource": true
        }');
        return $response;
    })
);

$server->addEndpoint($endpoint);

/**
 * Note: after server will be run, php script going to loop and code after this line not be executed.
 */
$server->run();