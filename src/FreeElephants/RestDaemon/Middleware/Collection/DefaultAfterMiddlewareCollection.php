<?php

namespace FreeElephants\RestDaemon\Middleware\Collection;

use FreeElephants\RestDaemon\Middleware\MiddlewareRole;
use FreeElephants\RestDaemon\Middleware\NoContentStatusSetter;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DefaultAfterMiddlewareCollection extends AbstractMiddlewareCollection
{

    protected function getDefaultMiddleware(): array
    {
        return $this->defaultBeforeMiddlewareMap ?: $this->defaultBeforeMiddlewareMap = [
            MiddlewareRole::NO_CONTENT_STATUS_SETTER => new NoContentStatusSetter(),
        ];
    }
}