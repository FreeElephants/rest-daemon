<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use Psr\Container\ContainerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class CloningHandlerFactory implements HandlerFactoryInterface
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
        return clone $this->di->get($className);
    }
}