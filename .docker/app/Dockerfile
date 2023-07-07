FROM php:8.1.4-fpm-alpine3.14

ENV TZ=Europe/Minsk

RUN apk add --update --no-cache \
    curl \
    zsh \
    zip \
    shadow \
    autoconf \
    bash \
 && echo "date.timezone=$TZ" > "$PHP_INI_DIR/conf.d/date-time-zone.ini" \
 && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=mlocati/php-extension-installer:1.5.36 /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions xdebug pdo pdo_mysql mysqli

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache bash \
    && curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash \
    && apk add symfony-cli

WORKDIR /var/www
ADD . .

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

RUN mkdir /var/.composer
RUN chown www-data:www-data /var/.composer

USER www-data

ENTRYPOINT ["/bin/sh", "/var/www/entrypoint.dev.sh"]
CMD ["/usr/local/sbin/php-fpm"]
