<?php

namespace FreeElephants\RestDaemon\HttpDriver\Aerys;

use Aerys\Request;
use Aerys\Response;
use FreeElephants\RestDaemon\Endpoint\Handler\EndpointMethodHandlerInterface;
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

    public function __invoke(Request $request, Response $response, array $routeParams)
    {
        $psrServerRequest = new ServerRequest($request);
        foreach ($routeParams as $name => $value) {
            $psrServerRequest = $psrServerRequest->withAttribute($name, $value);
        }
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