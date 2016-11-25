<?php

namespace FreeElephants\RestDaemon\Endpoint;

use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Relay\Relay;
use Relay\RelayBuilder;
use Zend\Diactoros\Response;
use Zend\Diactoros\Uri;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractEndpointMethodHandler implements EndpointMethodHandlerInterface
{

    /**
     * @var Relay
     */
    private $relay;
    /**
     * @var EndpointInterface
     */
    private $endpoint;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->relay->__invoke($request, new Response());
    }

    abstract public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface;

    public function setEndpoint(EndpointInterface $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function getEndpoint(): EndpointInterface
    {
        return $this->endpoint;
    }

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $endpointMiddlewareCollection)
    {
        $relayBuilder = new RelayBuilder();
        $this->relay = $relayBuilder->newInstance($endpointMiddlewareCollection->wrapInto([$this, '__invoke']));
    }

    public function getBaseServerUri(ServerRequestInterface $request): UriInterface
    {
        $uri = $request->getUri();
        $portPart = $uri->getPort() ? $uri->getPort() . ':' : '';
        $uriString = $uri->getScheme() . '://' . $uri->getHost() . $portPart . '/';

        return new Uri($uriString);
    }

}