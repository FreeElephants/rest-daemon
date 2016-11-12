<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\RestDaemon\ExceptionHandler\ExceptionHandlerInterface;
use Ratchet\App;
use Relay\Relay;
use Relay\RelayBuilder;
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

    private $middlewareStack = [];
    private $afterEndpointMiddleware = [];

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
        $relay = new RelayBuilder();
        $dispatcher = $relay->newInstance($this->middlewareStack);
        foreach ($this->endpoints as $endpoint) {
            foreach ($endpoint->getMethodHandlers() as $method => $handler) {
                $handler->setMiddleware($this->middlewareStack, $this->afterEndpointMiddleware);
                $path = $endpoint->getPath();
                $controller = new BaseHttpServer($handler);
                $defaults = ['_controller' => $controller];
                $requirements = ['Origin' => $this->httpHost];
                $options = [];
                $allowedMethods = [$method];
                $route = new Route($path, $defaults, $requirements, $options, $this->httpHost, $schemes = [],
                    $allowedMethods);
                $ratchetApp->routes->add($endpoint->getName(), $route);
            }
        }
        $ratchetApp->run();
    }

    public function setMiddlewareStack($middlewareStack, $afterEndpoint = [])
    {
        $this->middlewareStack = $middlewareStack;
        $this->afterEndpointMiddleware = $afterEndpoint;
    }
}