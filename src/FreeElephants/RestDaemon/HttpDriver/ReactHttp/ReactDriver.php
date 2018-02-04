<?php

namespace FreeElephants\RestDaemon\HttpDriver\ReactHttp;

use FreeElephants\RestDaemon\Endpoint\EndpointInterface;
use FreeElephants\RestDaemon\Endpoint\Handler\EndpointMethodHandlerInterface;
use FreeElephants\RestDaemon\HttpDriver\HttpDriverInterface;
use FreeElephants\RestDaemon\HttpDriver\HttpServerConfig;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Server;

class ReactDriver implements HttpDriverInterface
{

    /**
     * @var Server
     */
    private $server;
    /**
     * @var HttpServerConfig
     */
    private $config;

    public function getVendorName(): string
    {
        return 'react/http';
    }

    /**
     * @internal be careful: it's strong dependency without cross-vendor adapting: pre-configured Ratchet or Aerys instance
     * @return Server
     */
    public function getRawInstance()
    {
        return $this->server;
    }

    /**
     * @param HttpServerConfig $config
     * @param array|EndpointInterface[] $endpoints
     * @param EndpointMiddlewareCollectionInterface $middlewareCollection
     * @return mixed - configured original http server: aerys or ratchet app
     */
    public function configure(
        HttpServerConfig $config,
        array $endpoints,
        EndpointMiddlewareCollectionInterface $middlewareCollection
    ) {
        $this->config = $config;
        $routeCollection = (new RouteCollectionBuilder())->buildEndpointsRouteCollection($endpoints,
            $middlewareCollection, $config->getHttpHost());
        $router = new \FreeElephants\RestDaemon\HttpDriver\ReactHttp\Router($routeCollection);
        $this->server = new Server(function (ServerRequestInterface $request) use ($router) {
            $handler = $router->getHandler($request);
            if ($handler instanceof EndpointMethodHandlerInterface) {
                return $handler->handle($request);
            } else {
                return $handler($request);
            }
        });
        $this->server->on('error', function (\Exception $e) {
            echo 'Error: ' . $e->getMessage() . PHP_EOL;
            echo $e->getPrevious()->getMessage() . PHP_EOL;
        });
    }

    public function run()
    {
        $uri = $this->config->getAddress() . ':' . $this->config->getPort();
        $loop = Factory::create();
        $socket = new \React\Socket\Server($uri, $loop);
        $this->server->listen($socket);
        $loop->run();
    }
}