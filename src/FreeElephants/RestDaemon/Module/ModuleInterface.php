<?php

namespace FreeElephants\RestDaemon\Module;

use FreeElephants\RestDaemon\Endpoint\EndpointInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface ModuleInterface
{

    public function addEndpoint(EndpointInterface $endpoint);

    public function getPath(): string;

    public function getName(): string;
}