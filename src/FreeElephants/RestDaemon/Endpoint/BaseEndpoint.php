<?php

namespace FreeElephants\RestDaemon\Endpoint;

use FreeElephants\RestDaemon\Module\ApiModuleInterface;

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
     * @var ApiModuleInterface
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
        $handler->setEndpoint($this);
        $this->handlers[$method] = $handler;
    }

    /**
     * @param array|EndpointMethodHandlerInterface[] $handlers
     */
    public function setMethodHandlers(array $handlers)
    {
        $this->handlers = [];
        foreach ($handlers as $methodName => $handler) {
            $this->setMethodHandler($methodName, $handler);
        }
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

    public function getModule(): ApiModuleInterface
    {
        return $this->module;
    }

    public function setModule(ApiModuleInterface $module)
    {
        $this->path = str_replace('//', '/', $module->getPath() . $this->path);
        $this->name = $module->getName() . ': ' . $this->name;
        $this->module = $module;
    }
}