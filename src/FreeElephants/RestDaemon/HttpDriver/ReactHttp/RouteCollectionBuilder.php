<?php


namespace FreeElephants\RestDaemon\HttpDriver\ReactHttp;


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
                $requirements = ['Origin' => $httpHost];
                $options = [];
                $schemes = [];
                $allowedMethods = [$method];
                $defaults = [
                    'handler' => $handler
                ];
                $route = new Route($path, $defaults, $requirements, $options, $httpHost, $schemes, $allowedMethods);
                $routeName = $method . ':' . $endpoint->getPath();

                $routeCollection->add($routeName, $route);
            }
        }

        return $routeCollection;

    }
}