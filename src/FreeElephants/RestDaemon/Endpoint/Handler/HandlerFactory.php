<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use FreeElephants\RestDaemon\Endpoint\EndpointMethodHandlerInterface;
use Psr\Container\ContainerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class HandlerFactory implements HandlerFactoryInterface
{

    /**
     * @var ContainerInterface
     */
    private $di;

    public function __construct(ContainerInterface $di)
    {
        $this->di = $di;
    }

    public function buildHandler(string $className): EndpointMethodHandlerInterface
    {
        return new $className;
    }
}