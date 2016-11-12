<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\RestDaemon\ExceptionHandler\JsonExceptionHandler;
use Guzzle\Http\Message\RequestInterface as GuzzleRequestInterface;
use Guzzle\Http\Message\Response as GuzzleResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServerInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\ServerRequest;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BaseHttpServer implements HttpServerInterface
{

    /**
     * @var EndpointMethodHandlerInterface
     */
    private $handler;
    private $exceptionHandler;

    public function __construct(EndpointMethodHandlerInterface $handler)
    {
        $this->handler = $handler;
        $this->exceptionHandler = new JsonExceptionHandler();
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        $response = $this->exceptionHandler->handleException($e);
        $conn->send($this->mapPsrResponseToGuzzle($response));
        $conn->close();
    }

    /**
     * @param \Ratchet\ConnectionInterface $conn
     * @param \Guzzle\Http\Message\RequestInterface $request null is default because PHP won't let me overload; don't pass null!!!
     * @throws \UnexpectedValueException if a RequestInterface is not passed
     */
    public function onOpen(ConnectionInterface $conn, GuzzleRequestInterface $request = null)
    {
        $response = $this->handler->handle(new ServerRequest());
        $conn->send($this->mapPsrResponseToGuzzle($response));
        $conn->close();
    }

    protected function mapPsrResponseToGuzzle(ResponseInterface $response): GuzzleResponse
    {
        return new GuzzleResponse($response->getStatusCode(), $response->getHeaders(), $response->getBody());
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        // called after success request handling
    }

    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string $msg The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        // not used in rest server
    }
}