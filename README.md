# Rest-Daemon

Simple PHP7 framework for fast building REST services based on middleware, PSR-7 and react.  
  
See example in example/rest-server.php. 
 
Features: 
- Middleware oriented request/response handling
- Priority PSR's support: PSR-2, -3, -4, -7, -15 and other. 
- Built-in Middleware for support usual REST features, like HTTP based semantic, content types, request parsing, headers. 
- Chose on of two available http-daemon drivers: Ratchet (ReactPHP) or Aerys (amphp). 


Installation: 
```
composer require free-elephants/rest-daemon
```