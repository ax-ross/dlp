FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

COPY crontab /etc/crontabs/root
WORKDIR /var/www

CMD ["crond", "-f"]
