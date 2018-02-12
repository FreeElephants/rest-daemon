<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use FreeElephants\DI\Injector;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class InjectionHandlerFactory implements HandlerFactoryInterface
{

    use LoggerAwareTrait;

    /**
     * @var Injector
     */
    private $injector;

    public function __construct(Injector $injector)
    {
        $this->logger = new NullLogger();
        $this->injector = $injector;
    }

    public function buildHandler(string $className): EndpointMethodHandlerInterface
    {
        $this->logger->debug(sprintf('Build handler %s', $className));

        return $this->injector->createInstance($className);
    }
}