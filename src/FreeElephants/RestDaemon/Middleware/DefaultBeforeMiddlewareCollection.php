<?php

namespace FreeElephants\RestDaemon\Middleware;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DefaultBeforeMiddlewareCollection extends AbstractMiddlewareCollection
{

    protected function getDefaultMiddleware(): array
    {
        return $this->defaultBeforeMiddlewareMap ?: $this->defaultBeforeMiddlewareMap = [
            MiddlewareRole::CONTENT_TYPE_SETTER => new ContentTypeSetter('application/json'),
            MiddlewareRole::ERROR_HANDLER => new JsonErrorHandler(),
        ];
    }
}