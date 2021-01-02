FROM bitnami/php-fpm:latest
RUN apt-get update && apt-get install -y autoconf build-essential
RUN pecl channel-update pecl.php.net
RUN pecl install mongodb
RUN echo "extension=mongodb.so" >> /opt/bitnami/php/etc/php.ini