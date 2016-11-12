<?php

namespace FreeElephants\RestDaemon\Middleware;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DefaultAfterMiddlewareCollection extends AbstractMiddlewareCollection
{

    protected function getDefaultMiddleware(): array
    {
        return $this->defaultBeforeMiddlewareMap ?: $this->defaultBeforeMiddlewareMap = [
        ];
    }
}