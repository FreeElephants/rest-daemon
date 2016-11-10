<?php

namespace FreeElephants\RestDaemon;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointInterface
{

    public function getPath(): string;

    public function getName(): string;

    public function setMethodHandler(string $method, MethodHandlerInterface $handler);

    /**
     * @param array|MethodHandlerInterface[] $handlers
     */
    public function setMethodHandlers(array $handlers);

    /**
     * @return array|MethodHandlerInterface[]
     */
    public function getMethodHandlers(): array;

    public function hasMethod(string $method): bool;
}