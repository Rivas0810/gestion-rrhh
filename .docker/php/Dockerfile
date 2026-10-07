FROM php:8.4-cli

ARG UID
ARG GID

RUN groupadd --gid ${GID} appgroup \
    && useradd --uid ${UID} --gid ${GID} --create-home appuser

RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        unzip \
        curl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

USER appuser
