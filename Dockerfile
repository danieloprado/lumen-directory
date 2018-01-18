from php:7-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN docker-php-source extract \
    && docker-php-ext-install pdo mbstring  \
    && docker-php-source delete \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /src

EXPOSE 8080

CMD php -S 0.0.0.0:8080 -t ./public