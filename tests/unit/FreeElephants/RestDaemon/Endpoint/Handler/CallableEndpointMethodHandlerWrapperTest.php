<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use FreeElephants\AbstractTestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class CallableEndpointMethodHandlerWrapperTest extends AbstractTestCase
{

    public function test__invoke()
    {
        $foo = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
            $response->getBody()->write('foo');
            return $next($request, $response);
        };

        $handler = new CallableEndpointMethodHandlerWrapper($foo);

        $response = $handler(new ServerRequest(), new Response(),
            function (ServerRequestInterface $request, ResponseInterface $response) {
                $response->getBody()->rewind();
                return $response;
            });

        $this->assertSame('foo', $response->getBody()->getContents());
    }
    
}