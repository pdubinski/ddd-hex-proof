FROM php:8.2-fpm

RUN apt-get update
RUN apt-get install -y curl git sudo \
    && apt-get install -y mariadb-client procps \
    && docker-php-ext-install pdo pdo_mysql opcache

#RUN apt-get install zip unzip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Warsaw /etc/localtime
RUN "date"
ENV APPLICATION_ENV=dev-docker

WORKDIR /var/www
