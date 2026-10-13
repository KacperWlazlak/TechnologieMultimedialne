
FROM php:8.3-apache

RUN docker-php-ext-install mysqli

RUN a2dismod mpm_event mpm_worker \
    && a2enmod mpm_prefork

COPY . /var/www/html/

EXPOSE 80

CMD ["sh", "-c", "a2dismod mpm_event mpm_worker && a2enmod mpm_prefork && exec apache2-foreground"]
