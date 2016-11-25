<?php

namespace FreeElephants\RestDaemon\Endpoint;

use FreeElephants\RestDaemon\Module\ModuleInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointInterface
{

    public function getPath(): string;

    public function getName(): string;

    public function getModule(): ModuleInterface;

    public function setModule(ModuleInterface $module);

    public function setMethodHandler(string $method, EndpointMethodHandlerInterface $handler);

    /**
     * @param array|callable[] $handlers
     */
    public function setMethodHandlers(array $handlers);

    /**
     * @return array|EndpointMethodHandlerInterface[]
     */
    public function getMethodHandlers(): array;

    public function hasMethod(string $method): bool;
}