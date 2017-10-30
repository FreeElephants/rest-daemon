<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface HandlerFactoryInterface
{
    public function buildHandler(string $className): EndpointMethodHandlerInterface;
}