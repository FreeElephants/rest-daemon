<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\RestDaemon\Exception\InvalidArgumentException;
use FreeElephants\RestDaemon\HttpDriver\HttpDriverInterface;
use FreeElephants\RestDaemon\HttpDriver\HttpServerConfig;
use FreeElephants\RestDaemon\HttpDriver\Ratchet\RatchetDriver;
use FreeElephants\RestDaemon\Middleware\DefaultEndpointMiddlewareCollection;
use FreeElephants\RestDaemon\Middleware\EndpointMiddlewareCollectionInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class RestServer
{
    const DEFAULT_HTTP_DRIVER = RatchetDriver::class;

    /**
     * @var array|EndpointInterface[]
     */
    private $endpoints = [];

    /**
     * @var EndpointMiddlewareCollectionInterface
     */
    private $middlewareCollection;
    /**
     * @var HttpDriverInterface
     */
    private $httpDriver;
    /**
     * @var HttpServerConfig
     */
    private $config;

    public function __construct(
        string $httpHost = HttpServerConfig::DEFAULT_HTTP_HOST,
        int $port = HttpServerConfig::DEFAULT_HTTP_PORT,
        string $address = HttpServerConfig::DEFAULT_ADDRESS,
        $allowedOrigins = HttpServerConfig::DEFAULT_ALLOWED_ORIGINS,
        string $httpDriverClass = self::DEFAULT_HTTP_DRIVER
    ) {
        $this->config = new HttpServerConfig($httpHost, $port, $address, $allowedOrigins);
        $this->httpDriver = $this->buildHttpDriver($httpDriverClass);
    }

    public function addEndpoint(EndpointInterface $endpoint)
    {
        $this->endpoints[] = $endpoint;
    }

    public function run()
    {
        $this->httpDriver->configure($this->config, $this->endpoints, $this->getMiddlewareCollection());
        cli_set_process_title('rest-deamon');
        $this->httpDriver->run();
    }

    protected function buildHttpDriver(string $httpDriverClass): HttpDriverInterface
    {
        if (!class_exists($httpDriverClass)) {
            throw new InvalidArgumentException();
        }
        return new $httpDriverClass;
    }

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $middlewareCollection)
    {
        $this->middlewareCollection = $middlewareCollection;
    }

    public function getMiddlewareCollection(): EndpointMiddlewareCollectionInterface
    {
        return $this->middlewareCollection ?: $this->middlewareCollection = new DefaultEndpointMiddlewareCollection();
    }
}