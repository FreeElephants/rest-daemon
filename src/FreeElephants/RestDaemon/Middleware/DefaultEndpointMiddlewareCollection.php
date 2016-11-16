<?php

namespace FreeElephants\RestDaemon\Middleware;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DefaultEndpointMiddlewareCollection implements EndpointMiddlewareCollectionInterface
{

    protected $before;

    protected $after;

    public function __construct(array $before = [], array $after = [])
    {
        $this->before = new DefaultBeforeMiddlewareCollection($before);
        $this->after = new DefaultAfterMiddlewareCollection($after);
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