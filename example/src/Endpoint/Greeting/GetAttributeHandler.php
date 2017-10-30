<?php

namespace RestDeamon\Example\Endpoint\Greeting;

use FreeElephants\RestDaemon\Endpoint\Handler\AbstractEndpointMethodHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class GetAttributeHandler extends AbstractEndpointMethodHandler
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        $name = $request->getAttribute('name', 'World');
        $response->getBody()->write('{
            "hello": "' . $name . '!"
        }');
        return $next($request, $response);
    }
}