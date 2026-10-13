
FROM php:8.3-apache

RUN docker-php-ext-install mysqli

RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    /etc/apache2/mods-enabled/mpm_worker.load \
    && a2enmod mpm_prefork

COPY . /var/www/html/

RUN apache2ctl configtest

EXPOSE 80
