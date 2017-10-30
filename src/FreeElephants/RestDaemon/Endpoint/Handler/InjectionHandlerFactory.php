<?php


namespace FreeElephants\RestDaemon\Endpoint\Handler;


use FreeElephants\DI\Injector;
use FreeElephants\RestDaemon\Endpoint\EndpointMethodHandlerInterface;

class InjectionHandlerFactory implements HandlerFactoryInterface
{

    /**
     * @var Injector
     */
    private $injector;

    public function __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

    public function buildHandler(string $className): EndpointMethodHandlerInterface
    {
        return $this->injector->createInstance($className);
    }
}