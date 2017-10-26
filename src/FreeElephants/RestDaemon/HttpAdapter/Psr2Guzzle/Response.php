<?php

namespace FreeElephants\RestDaemon\HttpAdapter\Psr2Guzzle;

use Psr\Http\Message\ResponseInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Response extends \Zend\Diactoros\Response
{

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response->getBody(), $response->getStatusCode(), $response->getHeaders());
    }

    public function __toString()
    {
        $this->getBody()->rewind();
        $output = 'HTTP/' . $this->getProtocolVersion() . ' ' . $this->getStatusCode() . ' ' . $this->getReasonPhrase() . "\r\n";

        foreach ($this->getHeaders() as $name => $values) {
            $output .= $name . ": " . implode(", ", $values) . "\r\n";
        }
//        foreach ($this->getHeaders() as $name => $values) {
//            $output .= $this->getHeaderLine($name) . "\r\n";
//        }
        $output .= $this->getBody()->getContents();
        return $output;
    }
}