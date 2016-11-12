<?php

namespace FreeElephants\RestDaemon\Middleware;

use FreeElephants\RestDaemon\EndpointMethodHandlerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DefaultEndpointMiddlewareCollection implements EndpointMiddlewareCollectionInterface
{

    protected $before;

    protected $after;

    public function __construct()
    {
        $this->before = new DefaultBeforeMiddlewareCollection();
        $this->after = new DefaultAfterMiddlewareCollection();
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
}