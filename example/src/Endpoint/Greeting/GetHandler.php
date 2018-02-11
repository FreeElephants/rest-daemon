<?php

namespace RestDaemon\Example\Endpoint\Greeting;

use FreeElephants\RestDaemon\Endpoint\Handler\AbstractEndpointMethodHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class GetHandler extends AbstractEndpointMethodHandler
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        parse_str($request->getUri()->getQuery(), $params);
        $name = array_key_exists('name', $params) ? $params['name'] : 'World';
        $response->getBody()->write('{
            "hello": "' . $name . '!"
        }');
        return $next($request, $response);
    }
}