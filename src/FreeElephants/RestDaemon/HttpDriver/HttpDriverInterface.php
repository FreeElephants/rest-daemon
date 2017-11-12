<?php

namespace FreeElephants\RestDaemon\HttpDriver;

use Aerys\Host;
use FreeElephants\RestDaemon\Endpoint\EndpointInterface;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use Ratchet\App;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface HttpDriverInterface
{

    public function getVendorName(): string;

    /**
     * @internal be careful: it's strong dependency without cross-vendor adapting: pre-configured Ratchet or Aerys instance
     * @return App|Host
     */
    public function getRawInstance();

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
    );

    public function run();
}