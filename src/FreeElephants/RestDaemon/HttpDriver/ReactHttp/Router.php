<?php

namespace FreeElephants\RestDaemon\HttpDriver\ReactHttp;

use FreeElephants\RestDaemon\Endpoint\Handler\EndpointMethodHandlerInterface;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Routing\RouteCollection;

class Router
{

    /**
     * @var RouteCollection
     */
    private $routeCollection;

    public function __construct(RouteCollection $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }

    public function getHandler(RequestInterface $request): EndpointMethodHandlerInterface
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        if ($method === 'HEAD') {
            $method = 'GET';
        }
        $routeName = $method . ':' . $path;
        
        return $this->routeCollection->get($routeName)->getDefault('handler');
    }
}