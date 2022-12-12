FROM php:8.1-fpm
RUN apt-get update \
    && apt-get install -y zlib1g-dev vim libzip-dev \
    && docker-php-ext-install zip pdo_mysql
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY php.ini /usr/local/etc/php/
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

SHELL [ "/bin/bash", "-c" ]
## 現時点のLTSのバージョンを指定する
ENV NODE_VERSION v16.17.0

# nvmをインストール
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash

RUN source /root/.nvm/nvm.sh \
    && nvm install $NODE_VERSION \
    && nvm alias default $NODE_VERSION \
    && nvm use default
WORKDIR /var/www