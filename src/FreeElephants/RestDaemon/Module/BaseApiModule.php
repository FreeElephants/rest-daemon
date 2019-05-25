<?php

namespace FreeElephants\RestDaemon\Module;

use FreeElephants\RestDaemon\Endpoint\EndpointInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BaseApiModule implements ApiModuleInterface
{

    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $name;

    /**
     * @var array|EndpointInterface[]
     */
    private $endpoints = [];

    public function __construct(string $path, string $name = null)
    {
        $this->path = $path;
        $this->name = $name;
    }

    public function addEndpoint(EndpointInterface $endpoint)
    {
        $endpoint->setModule($this);
        $this->endpoints[$endpoint->getPath()] = $endpoint;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array|EndpointInterface
     */
    public function getEndpoints(): array
    {
        return $this->endpoints;
    }
}