# Rest-Daemon

**Nota Bene:** 
This project use semver and [changelog](CHANGELOG.md). 
But it's not stable major version. 
Any minor update (f.e.: 0.5.* -> 0.6.*) can break backward compatibility!    

Simple PHP7 framework for fast building REST services based on middleware, PSR-7 and react.   
 
## Features: 

- Middleware oriented request/response handling
- Priority PSR's support: PSR-2, -3, -4, -7, -15 and other. 
- Built-in Middleware for support usual REST features, like HTTP based semantic, content types, request parsing, headers. 
- Chose on of two available http-daemon drivers: Ratchet (ReactPHP) or Aerys (amphp). 


## Installation 

```
composer require free-elephants/rest-daemon
```

## Usage

See example in example/rest-server.php. 

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
```
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

### Configure Common Application Middleware

By default server instance provide collection with some useful middleware. 
You can extend or override it: 
```
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
```
$server->getMiddlewareCollection()->getBefore()->offsetUnset(\FreeElephants\RestDaemon\Middleware\MiddlewareRole::NO_CONTENT_STATUS_SETTER);
```

### Customize Endpoint Middleware
... _Will be implemented..._

### Debugging and Logging
... _Will be implemented..._
