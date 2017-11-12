# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/). 

Items with *BC!* note about backwards compatibility breaks!     

## [Unreleased]
### Added
- [#14]: OPTIONS HTTP method supports enabling by default. 
- FreeElephants\RestDaemon\Endpoint\OptionsMethodHandler class.  
- MiddlewareRole::X_POWERED_HEADER_SETTER. 
- XPoweredBySetter middleware: now response headers contains actual X-Powered-By Header with vendor versions.
- HttpDriverInterface::getVendorName() method. 
- setServer() method in MiddlewareCollectionInterface and EndpointMiddlewareCollectionInterface. 

### Changed
- EndpointFactory mixin OptionsMethodHandler by default if another not present in endpoint configuration. 
- *BC!*: MiddlewareCollections accept RestServer instance in first costructor argument. 

## [0.8.0] - 2017-10-31
## Renamed
- *BC!*: HandlerFactory -> DefaultHandlerFactory. 
- *BC!*: FreeElephants\RestDaemon\Endpoint\AbstractEndpointMethodHandler -> FreeElephants\RestDaemon\Endpoint\Handler\AbstractEndpointMethodHandler
- *BC!*: FreeElephants\RestDaemon\Endpoint\CallableEndpointMethodHandlerWrapper -> FreeElephants\RestDaemon\Endpoint\Handler\CallableEndpointMethodHandlerWrapper
- *BC!*: FreeElephants\RestDaemon\Endpoint\EndpointMethodHandlerInterface -> FreeElephants\RestDaemon\Endpoint\Handler\EndpointMethodHandlerInterface

## Changed
- DefaultHandlerFactory not require PSR-11 ContainerInterface and just call constructor.

## Added 
- InjectingHandlerFactory - use FreeElephants/di Injector. 
- CloningHandlerFactory - use PSR-11 ContainerInterface and return clone of getting instance. 

## [0.7.1] - 2017-10-30
### Fixed
- Aerys driver. 

### Added
- HttpServerConfig getter and setter to RestServer. 
- Getters and setters for all fields in HttpServerConfig. 
- Second argument for HttpServerConfig to RestServerBuilder::buildServer() method. 

### Changed
- `array` type hinting for $allowedOrigins argument in HttpServerConfig and RestServer.

### Internal
- Add the .gitattributes file. 

## [0.7.0] - 2017-10-29
### Added
- Constants: RestServer::RATCHET_HTTP_DRIVER & RestServer::AERYS_HTTP_DRIVER. 
- Method RestServer::getModules(). 

### Internal
- Update aerys to v0.7.1. 
- Update codeception to v2.3. 
- Update php-di to v1.6. 

### Removed
- PsrContainerAdapter, php-di implement it now. 

### Changed
- *BC!*: RestServerBuilder costructor accept all required dependencies. 
- ModuleFactory use `path` as `name` if last not present in configuration properties. 

## [0.6.1] - 2017-10-27 
### Internal
- Update Ratchet to v0.4  

## [0.6.0] - 2017-10-26
### Added
- RestServerBuilder, array based configuration building.  

## [0.5.0] - 2017-03-30
### Added 
- $rawInstanceBeforeRunHool callable argument to RestServer.run() for low level vendor specific manipilation (Ratchet or Aerys). 

### Internal
- Update vendors, use Ratchet v0.3.6.  

## [0.4.0] - 2016-12-06
### Changed
- All not modules endpoints associated with default module in Rest Server.

### Internal 
- Remove unused dependency for FreeElephants/(php-)di

## [0.3.0] - 2016-11-25
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

## [0.2.0] - 2016-11-22
### Changed
- AbstractEndpointMethodHandler::__invoke() must return PSR RequestInterface now. 

## [0.1.1] - 2016-11-21
- Fix SuitableBodyParser behavior when matched parser not found: send response with 415 status code.   

## [0.1.0] - 2016-11-19
### Added 
- Send Access-Control-Allow-Origin header with wildcard by default.  

## [0.0.1] - 2016-11-19
### Added
- Adopt to use with one of two http-daemon drivers: Ratchet (ReactPHP) and Aerys (amphp). 
- All features. 

[Unreleased]: https://github.com/FreeElephants/rest-daemon/compare/0.8.0...HEAD
[0.8.0]: https://github.com/FreeElephants/rest-daemon/compare/0.7.1...0.8.0
[0.7.1]: https://github.com/FreeElephants/rest-daemon/compare/0.7.0...0.7.1
[0.7.0]: https://github.com/FreeElephants/rest-daemon/compare/0.6.1...0.7.0
[0.6.1]: https://github.com/FreeElephants/rest-daemon/compare/0.6.0...0.6.1
[0.6.0]: https://github.com/FreeElephants/rest-daemon/compare/0.5.0...0.6.0
[0.5.0]: https://github.com/FreeElephants/rest-daemon/compare/0.4.0...0.5.0
[0.4.0]: https://github.com/FreeElephants/rest-daemon/compare/0.3.0...0.4.0
[0.3.0]: https://github.com/FreeElephants/rest-daemon/compare/0.2.0...0.3.0
[0.2.0]: https://github.com/FreeElephants/rest-daemon/compare/0.1.1...0.2.0
[0.1.1]: https://github.com/FreeElephants/rest-daemon/compare/0.1.0...0.1.1
[0.1.0]: https://github.com/FreeElephants/rest-daemon/compare/0.0.1...0.1.0



