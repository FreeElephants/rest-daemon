<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use FreeElephants\RestDaemon\Endpoint\EndpointMethodHandlerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface HandlerFactoryInterface
{
    public function buildHandler(string $className): EndpointMethodHandlerInterface;
}