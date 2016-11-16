<?php

namespace FreeElephants\RestDaemon\HttpDriver\Aerys;

use Aerys\Request;
use Aerys\Response;
use FreeElephants\RestDaemon\Endpoint\EndpointMethodHandlerInterface;
use FreeElephants\RestDaemon\HttpAdapter\Aerys2Zend\ServerRequest;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class HandlerWrapper
{

    /**
     * @var EndpointMethodHandlerInterface
     */
    private $handler;

    public function __construct(EndpointMethodHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request, Response $response)
    {
        $psrServerRequest = new ServerRequest($request);
        $requestBody = yield $request->getBody();
        $psrServerRequest->getBody()->write($requestBody);
        $psrServerRequest->getBody()->rewind();
        $psrResponse = $this->handler->handle($psrServerRequest);
        $response->setStatus($psrResponse->getStatusCode());
        $response->setReason($psrResponse->getReasonPhrase());
        foreach ($psrResponse->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                $response->addHeader($name, $value);
            }
        }
        $psrResponse->getBody()->rewind();
        $response->end($psrResponse->getBody()->getContents());
    }
}