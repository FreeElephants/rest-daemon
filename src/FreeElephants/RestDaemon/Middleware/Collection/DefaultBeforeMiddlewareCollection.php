<?php

namespace FreeElephants\RestDaemon\Middleware\Collection;

use FreeElephants\RestDaemon\Middleware\AcceptHeaderChecker;
use FreeElephants\RestDaemon\Middleware\ContentTypeSetter;
use FreeElephants\RestDaemon\Middleware\CORSHeaderSetter;
use FreeElephants\RestDaemon\Middleware\Json\ErrorHandler;
use FreeElephants\RestDaemon\Middleware\MiddlewareRole;
use FreeElephants\RestDaemon\Middleware\OptionsHandler;
use FreeElephants\RestDaemon\Middleware\SuitableBodyParser;

/**
 *
 * @author samizdam <samizdam@inbox.ru>
 */
class DefaultBeforeMiddlewareCollection extends AbstractMiddlewareCollection
{

    protected function getDefaultMiddleware(): array
    {
        return $this->defaultBeforeMiddlewareMap ?: $this->defaultBeforeMiddlewareMap = [
            MiddlewareRole::CORS_HEADER_SETTER => new CORSHeaderSetter(),
//            MiddlewareRole::OPTIONS_HANDLER => new OptionsHandler(),
            MiddlewareRole::CONTENT_TYPE_SETTER => new ContentTypeSetter('application/json'),
            MiddlewareRole::ERROR_HANDLER => new ErrorHandler(),
            MiddlewareRole::ACCEPT_TYPE_CHECKER => new AcceptHeaderChecker('application/json'),
            MiddlewareRole::BODY_PARSER => new SuitableBodyParser(),
        ];
    }
}