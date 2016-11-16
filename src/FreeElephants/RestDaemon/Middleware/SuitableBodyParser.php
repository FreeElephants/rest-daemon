<?php

namespace FreeElephants\RestDaemon\Middleware;

use FreeElephants\RestDaemon\Exception\InvalidArgumentException;
use FreeElephants\RestDaemon\Util\AcceptMediaTypeMatcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class SuitableBodyParser implements MiddlewareInterface
{

    const DEFAULT_SUITABLE_METHODS = [
        'POST',
        'PUT',
        'PATCH'
    ];

    const DEFAULT_PARSERS_MATCH_MAP = [
        'application/json' => Json\BodyParser::class,
        'application/x-www-form-urlencoded' => Www\BodyParser::class,
    ];

    private $suitableMethods = self::DEFAULT_SUITABLE_METHODS;

    /**
     * @var MiddlewareInterface[]
     */
    private $parsers;

    /**
     * SuitableBodyParser constructor.
     * @param array $suitableMethods
     * @param array|null $parsers - map with custom [content-type -> parser]
     */
    public function __construct(
        array $suitableMethods = self::DEFAULT_SUITABLE_METHODS,
        array $parsers = self::DEFAULT_PARSERS_MATCH_MAP
    ) {
        $this->suitableMethods = $suitableMethods;
        $this->initParsers($parsers);
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface
    {
        if (in_array($request->getMethod(), $this->suitableMethods)) {
            if ($parser = $this->getMatchedParser($request)) {
                return $parser($request, $response, $next);
            } else {
                return $response->withStatus(415);
            }
        } else {
            return $next($request, $response);
        }
    }

    private function getMatchedParser(ServerRequestInterface $request): callable
    {
        $requestContentTypes = $request->getHeader('Content-Type');
        foreach ($requestContentTypes as $requestContentType) {
            foreach ($this->parsers as $contentType => $parser) {
                if (AcceptMediaTypeMatcher::match($contentType, $requestContentType)) {
                    return $parser;
                }
            }
        }

        return null;
    }

    private function initParsers($parsersMatchMap)
    {
        foreach ($parsersMatchMap as $contentType => $parserClass) {
            if (is_string($parserClass) && class_exists($parserClass)) {
                $parser = new $parserClass;
            } elseif (is_object($parserClass) || is_callable($parserClass)) {
                $parser = $parserClass;
            } else {
                throw new InvalidArgumentException('Parser must be existing class name or instance of middleware or callable');
            }
            $this->parsers[$contentType] = $parser;
        }
    }
}