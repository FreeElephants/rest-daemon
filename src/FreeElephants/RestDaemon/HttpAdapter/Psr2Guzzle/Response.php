<?php

namespace FreeElephants\RestDaemon\HttpAdapter\Psr2Guzzle;

use Guzzle\Http\Message\Response as GuzzleResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Response extends GuzzleResponse
{

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response->getStatusCode(), $response->getHeaders(), $response->getBody());
    }
}