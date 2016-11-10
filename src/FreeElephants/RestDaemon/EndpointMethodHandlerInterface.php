<?php

namespace FreeElephants\RestDaemon;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointMethodHandlerInterface
{

    public function handle(RequestInterface $request): Response;
}