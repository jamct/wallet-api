FROM openswoole/swoole:latest-alpine

RUN apk add libzip-dev zip bash
RUN docker-php-ext-install opcache pcntl zip

COPY src /code
COPY scripts/run.sh /run.sh
CMD mkdir /opt/certs
WORKDIR /code

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer install

CMD /run.sh