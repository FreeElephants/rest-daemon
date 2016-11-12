<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\RestDaemon\Middleware\DefaultEndpointMiddlewareCollection;
use FreeElephants\RestDaemon\Middleware\EndpointMiddlewareCollectionInterface;
use Ratchet\App;
use Symfony\Component\Routing\Route;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class RestServer
{

    /**
     * @var string
     */
    private $httpHost;
    /**
     * @var int
     */
    private $port;
    /**
     * @var string
     */
    private $address;
    /**
     * @var array
     */
    private $allowedOrigins;
    /**
     * @var array|EndpointInterface[]
     */
    private $endpoints = [];

    /**
     * @var EndpointMiddlewareCollectionInterface
     */
    private $middlewareCollection;

    public function __construct(
        string $httpHost = '127.0.0.1',
        int $port = 8080,
        string $address = '0.0.0.0',
        $allowedOrigins = ['*']
    ) {
        $this->httpHost = $httpHost;
        $this->port = $port;
        $this->address = $address;
        $this->allowedOrigins = $allowedOrigins;
    }

    public function addEndpoint(EndpointInterface $endpoint)
    {
        $this->endpoints[] = $endpoint;
    }

    /**
     *
     */
    public function run()
    {
        $ratchetApp = new App($this->httpHost, $this->port, $this->address);
        foreach ($this->endpoints as $endpoint) {
            foreach ($endpoint->getMethodHandlers() as $method => $handler) {
                $handler->setMiddlewareCollection($this->getMiddlewareCollection());
                $path = $endpoint->getPath();
                $controller = new BaseHttpServer($handler);
                $defaults = ['_controller' => $controller];
                $requirements = ['Origin' => $this->httpHost];
                $options = [];
                $allowedMethods = [$method];
                $route = new Route($path, $defaults, $requirements, $options, $this->httpHost, $schemes = [],
                    $allowedMethods);
                $ratchetApp->routes->add($endpoint->getName() . $method, $route);
            }
        }
        $ratchetApp->run();
    }

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $middlewareCollection)
    {
        $this->middlewareCollection = $middlewareCollection;
    }

    /**
     * @return EndpointMiddlewareCollectionInterface
     */
    public function getMiddlewareCollection(): EndpointMiddlewareCollectionInterface
    {
        return $this->middlewareCollection ?: $this->middlewareCollection = new DefaultEndpointMiddlewareCollection();
    }
}