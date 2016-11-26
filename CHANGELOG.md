# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## 0.4.0 - 2016-11-XX
### Changed
- All not modules endpoints associated with default module in Rest Server.  

## 0.3.0 - 2016-11-25
### Added
- Api Modules. 
- Method `EndpointMethodHandlerInterface::getBaseServerUri()` 

### Changed
- EndpointMethodHandlerInterface extend MiddlewareInterface. 

### Deprecated
- EndpointMethodHandlerInterface::handle() turned to final and should be changed to private.  

### Fixed
- Request scheme and host now available in handlers and middleware (see Ratchet fix https://github.com/ratchetphp/Ratchet/pull/471). Aerys driver fixed too. 

### Internal
- Extend CallableEndpointMethodHandlerWrapper from AbstractEndpointMethodHandler. 

## 0.2.0 - 2016-11-22
### Changed
- AbstractEndpointMethodHandler::__invoke() must return PSR RequestInterface now. 

## 0.1.1 - 2016-11-21
- Fix SuitableBodyParser behavior when matched parser not found: send response with 415 status code.   

## 0.1.0 - 2016-11-19
### Added 
- Send Access-Control-Allow-Origin header with wildcard by default.  

## 0.0.1 - 2016-11-19
### Added
- Adopt to use with one of two http-daemon drivers: Ratchet (ReactPHP) and Aerys (amphp). 
- All features. 