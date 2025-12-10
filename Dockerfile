FROM php:8.2-fpm

# dependencias del sistema
RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libonig-dev libxml2-dev libpq-dev \
    curl libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Crear usuario www-data (ya existe) y directorio de trabajo
WORKDIR /var/www

# Instalar node (opcional si necesitas assets)
# RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
#     && apt-get install -y nodejs

RUN useradd -u 1000 -m laravel
USER laravel


# Permisos iniciales
#RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]
