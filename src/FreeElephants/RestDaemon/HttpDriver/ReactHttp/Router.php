<?php

namespace FreeElephants\RestDaemon\HttpDriver\ReactHttp;

use FreeElephants\RestDaemon\Endpoint\Handler\EndpointMethodHandlerInterface;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Routing\RouteCollection;
use Zend\Diactoros\Response;

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

    public function getHandler(RequestInterface $request): callable
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        if ($method === 'HEAD') {
            $method = 'GET';
        }
        $routeName = $method . ':' . $path;

        if ($handler = $this->routeCollection->get($routeName)) {
            $handler = $handler->getDefault('handler');
            /**@var EndpointMethodHandlerInterface $handler */
            return $handler;
        } else {
            /**@var EndpointMethodHandlerInterface $optionsHandler */
            $optionsHandler = $this->routeCollection->get('OPTIONS:' . $path)->getDefault('handler');
            $methods = array_keys($optionsHandler->getEndpoint()->getMethodHandlers());
            return function () use ($methods) {
                return (new Response())->withStatus(405)->withHeader('Allow', $methods);
            };

        }
    }
}