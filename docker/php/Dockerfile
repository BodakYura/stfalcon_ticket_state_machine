ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0"

COPY --from=mlocati/php-extension-installer  /usr/bin/install-php-extensions /usr/local/bin/

RUN apt-get update \
    && apt-get -y upgrade \
    && apt-get install -y --no-install-recommends locales apt-utils git  \
    zlib1g-dev \
    libzip-dev \
    libicu-dev \
    libfreetype6-dev \
	libjpeg62-turbo-dev \
	libpng-dev \
    libwebp-dev \
    sudo \
    acl \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip pdo pdo_mysql intl opcache



RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

COPY ./php.ini /usr/local/etc/php/conf.d/
COPY --from=composer /usr/bin/composer /usr/bin/composer

CMD composer install ; setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var ; setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var ; php-fpm

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www