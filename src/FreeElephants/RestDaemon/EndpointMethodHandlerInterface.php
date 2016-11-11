<?php

namespace FreeElephants\RestDaemon;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointMethodHandlerInterface
{

    public function handle(RequestInterface $request): ResponseInterface;

    public function setMiddlewareStack(array $middlewareStack);
}