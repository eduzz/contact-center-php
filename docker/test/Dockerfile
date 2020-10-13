FROM php:7.2-cli

RUN set -x \
    && apt-get update \
    && apt-get install -y libxml2-dev curl libcurl4-openssl-dev git zip \
    && docker-php-ext-install -j$(nproc) soap curl \
    && pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug \
    && rm -rf /var/lib/apt/lists/* \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer  \
    && php -r "unlink('composer-setup.php');" \
    && export COMPOSER_ALLOW_SUPERUSER=1

RUN export COMPOSER_ALLOW_SUPERUSER=1 \ 
    && composer global require spatie/phpunit-watcher

WORKDIR /src

COPY docker/test/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY . /src

RUN composer install

CMD tail -f /src/composer.json