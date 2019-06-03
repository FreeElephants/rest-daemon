<?php declare(strict_types=1);

namespace FreeElephants\RestDaemon\HttpAdapter\Guzzle2Zend;

use FreeElephants\AbstractTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use Symfony\Component\HttpFoundation\Request;

class ServerRequestTest extends AbstractTestCase
{
    private const HEADER_ACCEPT = 'Accept';

    /** @test */
    public function construct_GuzzleRequest_ZendServerRequestCreated(): void
    {
        /** @var UriInterface|MockObject $uri */
        $uri = $this->createMock(UriInterface::class);
        $uri->method('getQuery')->willReturn('?foo=bar');
        /** @var RequestInterface|MockObject $guzzleRequest */
        $guzzleRequest = $this->createMock(RequestInterface::class);
        $guzzleRequest->method('getHeaders')->willReturn([self::HEADER_ACCEPT => 'application/json']);
        $guzzleRequest->method('getUri')->willReturn($uri);
        $guzzleRequest->method('getBody')->willReturn('php://temp');
        $guzzleRequest->method('getProtocolVersion')->willReturn('1.1');

        $zendRequest = new ServerRequest($guzzleRequest);

        $this->assertEquals('', $zendRequest->getUri());
        $this->assertEquals(Request::METHOD_GET, $zendRequest->getMethod());
        $this->assertEquals('', $zendRequest->getBody()->getContents());
        $this->assertTrue($zendRequest->hasHeader(self::HEADER_ACCEPT));
        $this->assertEquals('1.1', $zendRequest->getProtocolVersion());
    }
}
