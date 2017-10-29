<?php

namespace FreeElephants\RestDaemon\HttpDriver;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class HttpServerConfig
{

    const DEFAULT_HTTP_HOST = '127.0.0.1';
    const DEFAULT_HTTP_PORT = 8080;
    const DEFAULT_ADDRESS = '0.0.0.0';
    const DEFAULT_ALLOWED_ORIGINS = ['*'];
    /**
     * @var string
     */
    private $httpHost;
    /**
     * @var int
     */
    private $port;
    /**
     * @var string
     */
    private $address;
    /**
     * @var array
     */
    private $allowedOrigins;

    public function __construct(
        string $httpHost = self::DEFAULT_HTTP_HOST,
        int $port = self::DEFAULT_HTTP_PORT,
        string $address = self::DEFAULT_ADDRESS,
        array $allowedOrigins = self::DEFAULT_ALLOWED_ORIGINS
    ) {
        $this->setHttpHost($httpHost);
        $this->setPort($port);
        $this->setAddress($address);
        $this->setAllowedOrigins($allowedOrigins);
    }

    public function getHttpHost(): string
    {
        return $this->httpHost;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getAllowedOrigins(): array
    {
        return $this->allowedOrigins;
    }

    /**
     * @param string $httpHost
     */
    public function setHttpHost(string $httpHost)
    {
        $this->httpHost = $httpHost;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port)
    {
        $this->port = $port;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @param array $allowedOrigins
     */
    public function setAllowedOrigins(array $allowedOrigins)
    {
        $this->allowedOrigins = $allowedOrigins;
    }
}