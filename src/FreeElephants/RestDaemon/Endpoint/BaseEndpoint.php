<?php

namespace FreeElephants\RestDaemon\Endpoint;

use FreeElephants\RestDaemon\Module\ModuleInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BaseEndpoint implements EndpointInterface
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $path;

    /**
     * Array of handlers for http methods in this endpoint, indexed by method name.
     *
     * @var array|EndpointMethodHandlerInterface[]
     */
    private $handlers = [];
    /**
     * @var ModuleInterface
     */
    private $module;

    public function __construct(string $path, string $name = null)
    {
        $this->path = $path;
        $this->name = $name ?: $path . ' Endpoint';
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setMethodHandler(string $method, EndpointMethodHandlerInterface $handler)
    {
        $this->handlers[$method] = $handler;
    }

    /**
     * @param array|EndpointMethodHandlerInterface[] $handlers
     */
    public function setMethodHandlers(array $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @return array|EndpointMethodHandlerInterface[]
     */
    public function getMethodHandlers(): array
    {
        return $this->handlers;
    }

    public function hasMethod(string $method): bool
    {
        return array_key_exists($method, $this->handlers);
    }

    public function getModule(): ModuleInterface
    {
        return $this->module;
    }

    public function setModule(ModuleInterface $module)
    {
        $this->path = $module->getPath() . $this->path;
        $this->name = $module->getName() . ': ' . $this->name;
        $this->module = $module;
    }
}