# Dockerfile (para Symfony backend)
FROM php:8.1-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev git unzip zip \
    && docker-php-ext-install pdo pdo_pgsql

# Habilita mod_rewrite
RUN a2enmod rewrite

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia el código del backend
COPY . /var/www/html/

# Ajusta permisos
RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

# Instala dependencias PHP
RUN composer install

EXPOSE 80
