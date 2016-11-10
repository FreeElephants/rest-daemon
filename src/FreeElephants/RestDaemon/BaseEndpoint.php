<?php

namespace FreeElephants\RestDaemon;

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
     * @var array|MethodHandlerInterface[]
     */
    private $handlers = [];

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

    public function setMethodHandler(string $method, MethodHandlerInterface $handler)
    {
        $this->handlers[$method] = $handler;
    }

    /**
     * @param array|MethodHandlerInterface[] $handlers
     */
    public function setMethodHandlers(array $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @return array|MethodHandlerInterface[]
     */
    public function getMethodHandlers(): array
    {
        return $this->handlers;
    }

    public function hasMethod(string $method): bool
    {
        return array_key_exists($method, $this->handlers);
    }
}