FROM php:8.3-apache

# Instalacja rozszerzenia MySQL
RUN docker-php-ext-install mysqli

# Konfiguracja Apache
RUN a2dismod mpm_event mpm_worker \
    && a2enmod mpm_prefork

# Kopiowanie plików aplikacji
COPY . /var/www/html/

# Uprawnienia do folderów avatarów LAB 2 i LAB 3
RUN mkdir -p /var/www/html/z2/uploads \
    /var/www/html/z3/uploads \
    && chown -R www-data:www-data \
    /var/www/html/z2/uploads \
    /var/www/html/z3/uploads \
    && chmod 775 \
    /var/www/html/z2/uploads \
    /var/www/html/z3/uploads

# Port Apache
EXPOSE 80

# Uruchomienie Apache
CMD ["sh", "-c", "a2dismod mpm_event mpm_worker && a2enmod mpm_prefork && exec apache2-foreground"]
