<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use Psr\Log\LoggerAwareInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface HandlerFactoryInterface extends LoggerAwareInterface
{
    public function buildHandler(string $className): EndpointMethodHandlerInterface;
}