<?php

namespace FreeElephants\RestDaemon\HttpDriver\Ratchet;

use FreeElephants\RestDaemon\Endpoint\EndpointMethodHandlerInterface;
use FreeElephants\RestDaemon\ExceptionHandler\JsonExceptionHandler;
use FreeElephants\RestDaemon\HttpAdapter\Guzzle2Zend\ServerRequest;
use FreeElephants\RestDaemon\HttpAdapter\Psr2Guzzle\Response;
use Guzzle\Http\Message\EntityEnclosingRequest;
use Guzzle\Http\Message\RequestInterface as GuzzleRequestInterface;
use function GuzzleHttp\Psr7\str;
use Psr\Http\Message\RequestInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServerInterface;

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
        echo "======================\nERROR\n==================\n";
        var_dump($e->getMessage());
        exit;
        $response = $this->exceptionHandler->handleException($e);
        $conn->send(new Response($response));
        $conn->close();
    }

    /**
     * @param \Ratchet\ConnectionInterface $conn
     * @param \Guzzle\Http\Message\RequestInterface $request null is default because PHP won't let me overload; don't pass null!!!
     * @throws \UnexpectedValueException if a RequestInterface is not passed
     */
    public function onOpen(ConnectionInterface $conn, RequestInterface $request = null)
    {
        /**@var $request RequestInterface */
        var_dump(__METHOD__ . 'in');
        $psrRequest = new ServerRequest($request);
        var_dump('request builded');
        parse_str($request->getUri()->getQuery(), $queryParams);
        foreach ($queryParams as $name => $value) {
            $psrRequest = $psrRequest->withAttribute($name, $value);
        }
        $response = $this->handler->handle($psrRequest);
        $data = str($response);
        var_dump($data);
//        $conn->send($data);
        $conn->send($data);
//        var_dump('response sended');
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