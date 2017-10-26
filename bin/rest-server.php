<?php
/**
 * TODO: prepare Symfony console application for run server from vendor/bin as background daemon, with provided configuration via file / CLI options.
 */

require_once __DIR__ . '/../vendor/autoload.php';
// Your shell script
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;


class MyWebPage implements \Ratchet\Http\HttpServerInterface {

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  \Ratchet\ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(\Ratchet\ConnectionInterface $conn)
    {
        $conn->close();
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  \Ratchet\ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(\Ratchet\ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
    }

    /**
     * @param \Ratchet\ConnectionInterface $conn
     * @param \Psr\Http\Message\RequestInterface $request null is default because PHP won't let me overload; don't pass null!!!
     * @throws \UnexpectedValueException if a RequestInterface is not passed
     */
    public function onOpen(\Ratchet\ConnectionInterface $conn, \Psr\Http\Message\RequestInterface $request = null)
    {
        $conn->send('foo');
        $conn->close();
    }

    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string $msg The message received
     * @throws \Exception
     */
    function onMessage(\Ratchet\ConnectionInterface $from, $msg)
    {
        // TODO: Implement onMessage() method.
    }
}

$http = new HttpServer(new MyWebPage);

$server = IoServer::factory($http, 8080);
$server->run();