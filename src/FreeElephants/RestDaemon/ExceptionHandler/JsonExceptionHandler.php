<?php

namespace FreeElephants\RestDaemon\ExceptionHandler;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class JsonExceptionHandler implements ExceptionHandlerInterface
{

    public function handleException(\Exception $e): ResponseInterface
    {
        $response = new Response('php://memory', 500);
        $data = [
            'message' => $e->getMessage()
        ];
        $response->getBody()->write(json_encode($data));
        return $response;
    }
}