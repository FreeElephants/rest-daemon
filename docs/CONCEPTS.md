# Base Concepts of Rest Daemon

## Endpoint

_Endpoint_ it is resource in your RESTful API.  

See [EndpointInterface](/src/FreeElephants/RestDaemon/Endpoint/EndpointInterface.php) for details.

## Endpoint Method Handler

Every _endpoint_ can have accept several methods: GET, POST, DELETE, etc...

See [EndpointMethodHandlerInterface](/src/FreeElephants/RestDaemon/Endpoint/Handler/EndpointMethodHandlerInterface.php).

## Module

_Module_ is group of endpoints with same prefix in path. 
For example, you can define version 1 of API as one module, and another module for v1.

```php
<?php
return [
    'modules' => [
        '/api/v1' => [
            'endpoints' => [
                /*...*/              
            ],
         ],    
        '/api/v2' => [
            'endpoints' => [
                /*...*/              
            ],            
         ],    
    ],
];
```

See [ApiModuleInterface](/src/FreeElephants/RestDaemon/Module/ApiModuleInterface.php).

## Middleware Collections

_Middleware_ it's code that running before, or after you handlers. 

See [EndpointMiddlewareCollectionInterface](/src/FreeElephants/RestDaemon/Middleware/Collection/EndpointMiddlewareCollectionInterface.php).