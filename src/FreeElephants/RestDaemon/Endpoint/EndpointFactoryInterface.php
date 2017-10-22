<?php

namespace FreeElephants\RestDaemon\Endpoint;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointFactoryInterface
{

    public function buildEndpoint(string $endpointPath, array $endpointConfig): EndpointInterface;
}