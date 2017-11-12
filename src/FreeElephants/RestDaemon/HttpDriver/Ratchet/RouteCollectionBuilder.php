<?php


namespace FreeElephants\RestDaemon\HttpDriver\Ratchet;


use FreeElephants\RestDaemon\Endpoint\EndpointInterface;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteCollectionBuilder
{
    
    /**
     * @param array|EndpointInterface[] $endpoints
     * @param EndpointMiddlewareCollectionInterface $middlewareCollection
     * @param string $httpHost
     * @return RouteCollection
     */
    public function buildEndpointsRouteCollection(
        array $endpoints,
        EndpointMiddlewareCollectionInterface $middlewareCollection,
        string $httpHost
    ): RouteCollection {
        $routeCollection = new RouteCollection();
        foreach ($endpoints as $endpoint) {
            $endpointMethodHandlers = $endpoint->getMethodHandlers();
            foreach ($endpointMethodHandlers as $method => $handler) {
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
}