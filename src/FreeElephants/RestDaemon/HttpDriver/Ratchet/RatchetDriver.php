<?php

namespace FreeElephants\RestDaemon\HttpDriver\Ratchet;

use FreeElephants\RestDaemon\HttpDriver\HttpDriverInterface;
use FreeElephants\RestDaemon\HttpDriver\HttpServerConfig;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use Ratchet\App;
use Ratchet\ConnectionInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class RatchetDriver implements HttpDriverInterface
{

    /**
     * @var App
     */
    private $server;
    /**
     * @var RouteCollectionBuilder
     */
    private $routeCollectionBuilder;

    public function __construct(RouteCollectionBuilder $routeCollectionBuilder = null)
    {
        $this->routeCollectionBuilder = $routeCollectionBuilder ?: new RouteCollectionBuilder();
    }

    public function configure(
        HttpServerConfig $config,
        array $endpoints,
        EndpointMiddlewareCollectionInterface $middlewareCollection
    ) {
        $this->server = new App($config->getHttpHost(), $config->getPort(), $config->getAddress());
        $routeCollection = $this->routeCollectionBuilder->buildEndpointsRouteCollection($endpoints,
            $middlewareCollection,
            $config->getHttpHost());
        $this->server->routes->addCollection($routeCollection);
        return $this->server;
    }

    public function run()
    {
        $this->server->run();
    }

    /**
     * @internal be careful: it's strong dependency without cross-vendor adapting: pre-configured Ratchet or Aerys instance
     * @return App
     */
    public function getRawInstance()
    {
        return $this->server;
    }

    public function getVendorName(): string
    {
        if (interface_exists(ConnectionInterface::class)) {
            // FIXME
            // call autoload for get constant defined in it namespace!
        }
        return \Ratchet\VERSION;
    }
}