from php:7-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN docker-php-source extract \
    && docker-php-ext-install pdo mbstring pdo_mysql  \
    && docker-php-source delete \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /src

EXPOSE 8080

CMD /bin/sh /src/start-docker.sh