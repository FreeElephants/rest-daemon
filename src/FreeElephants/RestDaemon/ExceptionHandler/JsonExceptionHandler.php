<?php

namespace FreeElephants\RestDaemon\ExceptionHandler;

use Guzzle\Http\Message\Response;

/**
 * @author samizdam <samizdam@inbox.ru>
 *
 * TODO: implement as middleware
 */
class JsonExceptionHandler implements ExceptionHandlerInterface
{

    public function handleError(\Exception $exception): Response
    {
        $response = new Response(500);
        $data = json_encode([
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
        ]);
        $response->setBody($data);
        return $response;
    }
}