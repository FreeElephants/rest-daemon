# Use Rest Daemon with Docker

Some example of Dockerfile
```dockerfile
FROM php:7.2.1-zts-stretch

WORKDIR /srv/my-rest-api

COPY bin/ bin/
COPY src/ src/
COPY vendor/ vendor/

CMD php /srv/my-rest-api/bin/api.php
```