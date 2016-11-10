<?php

namespace FreeElephants\RestDaemon;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointInterface
{

    public function getPath(): string;

    public function getName(): string;

    public function setMethodHandler(string $method, EndpointMethodHandlerInterface $handler);

    /**
     * @param array|EndpointMethodHandlerInterface[] $handlers
     */
    public function setMethodHandlers(array $handlers);

    /**
     * @return array|EndpointMethodHandlerInterface[]
     */
    public function getMethodHandlers(): array;

    public function hasMethod(string $method): bool;
}