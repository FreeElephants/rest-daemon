<?php

namespace FreeElephants\RestDaemon\Middleware\Collection;

use FreeElephants\RestDaemon\RestServer;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DefaultEndpointMiddlewareCollection implements EndpointMiddlewareCollectionInterface
{

    protected $before;

    protected $after;
    /**
     * @var RestServer
     */
    private $restServer;

    public function __construct(RestServer $restServer, array $before = [], array $after = [])
    {
        $this->before = new DefaultBeforeMiddlewareCollection($restServer, $before);
        $this->after = new DefaultAfterMiddlewareCollection($restServer, $after);
        $this->restServer = $restServer;
    }

    public function getBefore(): MiddlewareCollectionInterface
    {
        return $this->before;
    }

    public function getAfter(): MiddlewareCollectionInterface
    {
        return $this->after;
    }

    public function wrapInto(callable $middle): array
    {
        return array_merge(
            $this->getBefore()->getArrayCopy(),
            [$middle],
            $this->getAfter()->getArrayCopy()
        );
    }

    public function setServer(RestServer $restServer)
    {
        $this->restServer = $restServer;
    }
}