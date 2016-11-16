<?php

namespace FreeElephants\RestDaemon\HttpDriver;

use FreeElephants\RestDaemon\Endpoint\EndpointInterface;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface HttpDriverInterface
{

    /**
     * @param HttpServerConfig $config
     * @param array|EndpointInterface[] $endpoints
     * @param EndpointMiddlewareCollectionInterface $middlewareCollection
     * @return mixed - configured original http server: aerys or ratchet app
     */
    public function configure(HttpServerConfig $config, array $endpoints, EndpointMiddlewareCollectionInterface $middlewareCollection);

    public function run();
}