<?php declare(strict_types=1);

namespace FreeElephants\RestDaemon\HttpAdapter\Aerys2Zend;

use Aerys\Request;
use FreeElephants\AbstractTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class ServerRequestTest extends AbstractTestCase
{
    private const HEADER_ACCEPT = 'Accept';
    private const QUERY_PARAMETER = 'foo';
    private const QUERY_PARAMETER_VALUE = 'bar';
    private const QUERY_PARAMETERS = [self::QUERY_PARAMETER => self::QUERY_PARAMETER_VALUE];
    private const PROTOCOL_VERSION = '1.1';

    /** @test */
    public function construct_GuzzleRequest_ZendServerRequestCreated(): void
    {
        /** @var Request|MockObject $aerysRequest */
        $aerysRequest = $this->createMock(Request::class);
        $aerysRequest->method('getConnectionInfo')->willReturn([
            'server_addr'  => '',
            'server_port'  => 80,
            'is_encrypted' => false,
        ]);
        $aerysRequest->method('getMethod')->willReturn(HttpRequest::METHOD_GET);
        $aerysRequest->method('getAllHeaders')->willReturn([self::HEADER_ACCEPT => 'application/json']);
        $aerysRequest->method('getProtocolVersion')->willReturn(self::PROTOCOL_VERSION);
        $aerysRequest->method('getAllParams')->willReturn(self::QUERY_PARAMETERS);

        $zendRequest = new ServerRequest($aerysRequest);

        $this->assertEquals('http', $zendRequest->getUri()->getScheme());
        $this->assertEquals(HttpRequest::METHOD_GET, $zendRequest->getMethod());
        $this->assertEquals('', $zendRequest->getBody()->getContents());
        $this->assertTrue($zendRequest->hasHeader(self::HEADER_ACCEPT));
        $this->assertEquals(self::PROTOCOL_VERSION, $zendRequest->getProtocolVersion());
        $this->assertArrayHasKey(self::QUERY_PARAMETER, $zendRequest->getQueryParams());
        $this->assertContains(self::QUERY_PARAMETER_VALUE, $zendRequest->getQueryParams());
    }
}
