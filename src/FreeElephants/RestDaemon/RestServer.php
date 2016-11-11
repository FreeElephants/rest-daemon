<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\RestDaemon\ExceptionHandler\ExceptionHandlerInterface;
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
     * @var ExceptionHandlerInterface
     */
    private $exceptionHandler;
    private $middlewareStack;

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
                $handler->setMiddlewareStack($this->middlewareStack);
                $path = $endpoint->getPath();
                $controller = new BaseHttpServer($handler, $this->exceptionHandler);
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

    /**
     * @deprecated use middleware
     * @param ExceptionHandlerInterface $exceptionHandler
     */
    public function setExceptionHandler(ExceptionHandlerInterface $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }

    public function setMiddlewareStack(array $middlewareStack)
    {
        $this->middlewareStack = $middlewareStack;
    }
}