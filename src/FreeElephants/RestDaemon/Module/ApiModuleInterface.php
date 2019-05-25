<?php

namespace FreeElephants\RestDaemon\Module;

use FreeElephants\RestDaemon\Endpoint\EndpointInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface ApiModuleInterface
{

    public function addEndpoint(EndpointInterface $endpoint);

    public function getPath(): string;

    public function getName(): string;

    /**
     * Indexed by path
     *
     * @return array|EndpointInterface[]
     */
    public function getEndpoints(): array;
}