<?php

namespace FreeElephants\RestDaemon\HttpDriver\Ratchet;

use FreeElephants\RestDaemon\Endpoint\EndpointInterface;
use FreeElephants\RestDaemon\HttpDriver\HttpDriverInterface;
use FreeElephants\RestDaemon\HttpDriver\HttpServerConfig;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use Ratchet\App;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class RatchetDriver implements HttpDriverInterface
{

    /**
     * @var App
     */
    private $server;

    public function configure(
        HttpServerConfig $config,
        array $endpoints,
        EndpointMiddlewareCollectionInterface $middlewareCollection
    ) {
        $this->server = new App($config->getHttpHost(), $config->getPort(), $config->getAddress());
        $routeCollection = $this->buildEndpointsRouteCollection($endpoints, $middlewareCollection,
            $config->getHttpHost());
        $this->server->routes->addCollection($routeCollection);
        return $this->server;
    }

    public function run()
    {
        $this->server->run();
    }

    /**
     * @param array|EndpointInterface[] $endpoints
     * @param EndpointMiddlewareCollectionInterface $middlewareCollection
     * @param string $httpHost
     * @return RouteCollection
     */
    private function buildEndpointsRouteCollection(
        array $endpoints,
        EndpointMiddlewareCollectionInterface $middlewareCollection,
        string $httpHost
    ): RouteCollection
    {
        $routeCollection = new RouteCollection();
        foreach ($endpoints as $endpoint) {
            foreach ($endpoint->getMethodHandlers() as $method => $handler) {
                $handler->setMiddlewareCollection($middlewareCollection);
                $path = $endpoint->getPath();
                $controller = new BaseHttpServer($handler);
                $defaults = ['_controller' => $controller];
                $requirements = ['Origin' => $httpHost];
                $options = [];
                $schemes = [];
                $allowedMethods = [$method];
                $route = new Route($path, $defaults, $requirements, $options, $httpHost, $schemes, $allowedMethods);
                $routeName = $method . ':' . $endpoint->getName();
                $routeCollection->add($routeName, $route);
            }
        }

        return $routeCollection;
    }

    /**
     * @internal be careful: it's strong dependency without cross-vendor adapting: pre-configured Ratchet or Aerys instance
     * @return App
     */
    public function getRawInstance()
    {
        return $this->server;
    }
}