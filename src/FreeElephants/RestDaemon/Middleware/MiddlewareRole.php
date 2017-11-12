<?php

namespace FreeElephants\RestDaemon\Middleware;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class MiddlewareRole
{
    const CONTENT_TYPE_SETTER = 'content-type-setter';
    const ERROR_HANDLER = 'error-handler';
    const ACCEPT_TYPE_CHECKER = 'accept-type-checker';
    const BODY_PARSER = 'body-parser';
    const NO_CONTENT_STATUS_SETTER = 'no-content-status-setter';
    const CORS_HEADER_SETTER = 'CORS-header-setter';
    const X_POWERED_HEADER_SETTER = 'x-powered-header-setter';
}