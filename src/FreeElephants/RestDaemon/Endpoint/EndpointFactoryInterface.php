<?php

namespace FreeElephants\RestDaemon\Endpoint;

use Psr\Log\LoggerAwareInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointFactoryInterface extends LoggerAwareInterface
{

    public function buildEndpoint(string $endpointPath, array $endpointConfig): EndpointInterface;

    public function setAddOptionsHandler(bool $addOptionsHandler);

    public function allowGlobalRequestAllowHeaderReflecting(bool $allowGlobalRequestAllowHeaderReflecting);
}