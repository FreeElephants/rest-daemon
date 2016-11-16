<?php

namespace RestDeamon\Example\Endpoint\Greeting;

use FreeElephants\RestDaemon\Endpoint\AbstractEndpointMethodHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class PostHandler extends AbstractEndpointMethodHandler
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        parse_str($request->getBody()->getContents(), $params);
        $name = array_key_exists('name', $params) ? $params['name'] : 'World';
        $response->getBody()->write('{
            "hello": "' . $name . '!"
        }');
        return $next($request, $response);
    }
}