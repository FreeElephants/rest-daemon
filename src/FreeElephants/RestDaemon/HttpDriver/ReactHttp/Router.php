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
        $routeName = $request->getMethod() . ':' . $request->getUri()->getPath();
        var_dump($this->routeCollection->all());
        var_dump($routeName);
        return $this->routeCollection->get($routeName)->getDefault('handler');
    }
}