from php:7-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY start.sh /usr/local/bin/

RUN docker-php-source extract \
    && docker-php-ext-install pdo mbstring pdo_mysql  \
    && docker-php-source delete \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && set -x \
    && chmod 775 /usr/local/bin/* \
    && chmod +x /usr/local/bin/*.sh \
    && mkdir /src

WORKDIR /src

EXPOSE 8080

CMD start.sh