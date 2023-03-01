FROM php:7.1-apache

WORKDIR /var/www/html/

COPY . .

RUN echo "ServerName localhost:80" >> /etc/apache2/apache2.conf

RUN docker-php-ext-install pdo pdo_mysql

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]