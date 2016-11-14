<?php

namespace FreeElephants\RestDaemon;

use Aerys\Host;
use Aerys\Router;
use FreeElephants\RestDaemon\HttpAdapter\Aerys2Zend\ServerRequest;
use FreeElephants\RestDaemon\Middleware\DefaultEndpointMiddlewareCollection;
use FreeElephants\RestDaemon\Middleware\EndpointMiddlewareCollectionInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class AerysRestServer implements RestServerInterface
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
    private $middlewareCollection;

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

    public function run()
    {
        $router = new Router();
        foreach ($this->endpoints as $endpoint) {
            foreach ($endpoint->getMethodHandlers() as $method => $handler) {
                $handler->setMiddlewareCollection($this->getMiddlewareCollection());
                $router->route($method, $endpoint->getPath(),
                    function (\Aerys\Request $req, \Aerys\Response $resp) use ($handler) {
                        $request = new ServerRequest($req);
                        $requestBody = yield $req->getBody();
                        $request->getBody()->write($requestBody);
                        $request->getBody()->rewind();
                        $response = $handler->handle($request);
                        $resp->setStatus($response->getStatusCode());
                        $resp->setReason($response->getReasonPhrase());
                        foreach ($response->getHeaders() as $name => $values) {
                            foreach ($values as $value) {
                                $resp->addHeader($name, $value);
                            }
                        }
                        $response->getBody()->rewind();
                        $resp->end($response->getBody()->getContents());
                    });
            }
        }
        $aerysHost = new Host();
        $aerysHost->expose($this->httpHost, $this->port);
        $aerysHost->use($router);

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