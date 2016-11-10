<?php

namespace FreeElephants\RestDaemon\ExceptionHandler;

use Guzzle\Http\Message\Response;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class JsonExceptionHandler implements ExceptionHandlerInterface
{

    public function handleError(\Exception $exception): Response
    {
        $response = new Response(500);
        $data = json_encode([
            'message' => $exception->getMessage()
        ]);
        $response->setBody($data);
        return $response;
    }
}