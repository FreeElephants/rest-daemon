# Rest-Daemon

[![Build Status](https://travis-ci.org/FreeElephants/rest-daemon.svg?branch=master)](https://travis-ci.org/FreeElephants/rest-daemon) [![codecov](https://codecov.io/gh/FreeElephants/rest-daemon/branch/master/graph/badge.svg)](https://codecov.io/gh/FreeElephants/rest-daemon) [![Installs](https://img.shields.io/packagist/dt/free-elephants/rest-daemon.svg)](https://packagist.org/packages/free-elephants/rest-daemon) [![Releases](https://img.shields.io/packagist/v/free-elephants/rest-daemon.svg)](https://github.com/FreeElephants/rest-daemon/releases)

**Nota Bene:**
This project uses semver and [changelog](CHANGELOG.md).
But it's not a stable major version.
Any minor update (f.e. 0.5.* -> 0.6.*) can break backward compatibility!

Simple PHP7 framework for fast building REST services based on middleware, PSR-7 and react.

Runned instance can be found by [link](http://rest-daemon-example.samizdam.net:8080/uptime), also see [example repo](https://github.com/FreeElephants/rest-daemon-example).

## Features:

- Middleware oriented request/response handling
- Priority PSR's support: PSR-2, -3, -4, -7, -11, -15 and other. 
- Built-in Middleware to support usual REST features, like HTTP based semantics, content types, request parsing, headers. 
- Choose one of two available http-daemon drivers: Ratchet [ReactPHP](https://github.com/ratchetphp/Ratchet) or [Aerys](https://github.com/amphp/aerys). 
- [Swagger Integration](/docs/SWAGGER.md)

## Installation 

    $ composer require free-elephants/rest-daemon

## Usage

See example in example/rest-server.php and [documentation](/docs/INDEX.md). 

### Create and Run Server:

```
# your rest-server.php script
$server = new RestServer('127.0.0.1', 8080, '0.0.0.0', ['*']); // <- it's default arguments values
$server->run();

# can be runned as
$ php ./rest-server.php 
```

### Add Your RESTful API Endpoints

Any endpoint method handler can be Middleware-like callable implementation: function or class with __invoke() method.  
```php
<?php
class GetAttributeHandler extends AbstractEndpointMethodHandler
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $name = $request->getAttribute('name', 'World');
        $response->getBody()->write('{
            "hello": "' . $name . '!"
        }');
        return $next($request, $response);
    }
}

$greetingAttributeEndpoint = new BaseEndpoint('/greeting/{name}', 'Greeting by name in path');
$greetingAttributeEndpoint->setMethodHandler('GET', new GetAttributeHandler());

$server->addEndpoint($greetingAttributeEndpoint);
```

See how to [build server for step by step in one script](/example/rest-server-script-example.php)

### RestServerBuilder

You can use [php-di](https://github.com/free-elephants/php-di) (or another PSR-11 container implementation) and routing file configuration with RestServerBuilder for more configuring and coding less. 

See example with file based [routing](/example/routes.php) and [dependencies](/example/components.php) configuration: [rest-server.php](/example/rest-server.php)  

### Routing
You can link with every method in route a handler, and optionally organize routes by modules.  By default server contain 1 default module for all endpoints. 
See example: [routes.php](/example/routes.php)

### Configure Common Application Middleware

By default server instance provide collection with some useful middleware. 
You can extend or override it: 
```php
<?php
$requestCounter = function (
    ServerRequestInterface $request,
    ResponseInterface $response,
    callable $next
) {
    static $requestNumber = 0;
    printf('[%s] request number #%d handled' . PHP_EOL, date(DATE_ISO8601), ++$requestNumber);

    return $next($request, $response);
};
$extendedDefaultMiddlewareCollection = new DefaultEndpointMiddlewareCollection([], [$requestCounter]);
$server->setMiddlewareCollection($extendedDefaultMiddlewareCollection);
```

Every endpoint's method handler will be wrapped to this collection and called between defined as `after` and `before` middleware. 
Also you can configure default middleware collection with access to every built-in middleware by key: this collection implements ArrayAccess interface. 
```php
<?php
$server->getMiddlewareCollection()->getBefore()->offsetUnset(\FreeElephants\RestDaemon\Middleware\MiddlewareRole::NO_CONTENT_STATUS_SETTER);
```

### Customize Endpoint Middleware
... _Will be implemented..._

### Debugging and Logging
... _Will be implemented..._
