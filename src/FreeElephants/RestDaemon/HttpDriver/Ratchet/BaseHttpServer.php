<?php

namespace FreeElephants\RestDaemon\HttpDriver\Ratchet;

use FreeElephants\RestDaemon\Endpoint\Handler\EndpointMethodHandlerInterface;
use FreeElephants\RestDaemon\ExceptionHandler\JsonExceptionHandler;
use FreeElephants\RestDaemon\HttpAdapter\Guzzle2Zend\ServerRequest;
use Psr\Http\Message\RequestInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServerInterface;
use function GuzzleHttp\Psr7\str;

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
        $conn->send(str($response));
        $conn->close();
    }

    /**
     * @param ConnectionInterface $conn
     * @param RequestInterface $request
     */
    public function onOpen(ConnectionInterface $conn, RequestInterface $request = null)
    {
        /**@var $request RequestInterface */
        $psrRequest = new ServerRequest($request);
        parse_str($request->getUri()->getQuery(), $queryParams);
        foreach ($queryParams as $name => $value) {
            $psrRequest = $psrRequest->withAttribute($name, $value);
        }
        $response = $this->handler->handle($psrRequest);
        $data = str($response);
        $conn->send($data);
        $conn->close();
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