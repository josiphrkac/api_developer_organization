FROM php:7.4-apache

RUN apt-get update && \
    apt-get install -y git zip unzip && \
    rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/

RUN composer require vlucas/phpdotenv:^5.5

COPY . .

RUN composer install --optimize-autoloader --no-interaction

RUN echo "ServerName localhost:80" >> /etc/apache2/apache2.conf

RUN docker-php-ext-install pdo pdo_mysql




CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]