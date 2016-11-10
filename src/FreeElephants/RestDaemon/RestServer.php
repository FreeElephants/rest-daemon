<?php

namespace FreeElephants\RestDaemon;

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
                $path = $endpoint->getPath();
                $controller = new HttpServerAdapter($handler);
                $defaults = ['_controller' => $controller];
                $requirements = ['Origin' => $this->httpHost];
                $allowedMethods = [$method];
                $route = new Route($path, $defaults, $requirements, $allowedMethods, $this->httpHost);
                $ratchetApp->routes->add($endpoint->getName(), $route);
            }
        }
        $ratchetApp->run();
    }
}