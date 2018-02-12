<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class DefaultHandlerFactory implements HandlerFactoryInterface
{

    use LoggerAwareTrait;

    public function __construct()
    {
        $this->logger = new NullLogger();
    }

    public function buildHandler(string $className): EndpointMethodHandlerInterface
    {
        $this->logger->debug(sprintf('Build handler %s', $className));

        return new $className;
    }
}