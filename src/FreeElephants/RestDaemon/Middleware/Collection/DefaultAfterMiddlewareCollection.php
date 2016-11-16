<?php

namespace FreeElephants\RestDaemon\Middleware\Collection;

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