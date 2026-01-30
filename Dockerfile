FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html


COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]

