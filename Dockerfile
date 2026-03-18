FROM php:8.1-fpm-alpine

# Installation nginx et extensions PHP
RUN apk add --no-cache nginx \
    && docker-php-ext-install pdo pdo_mysql

# Installation Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copie du code dans l'image
COPY . .

# Installation des dépendances composer
RUN composer install --no-dev --optimize-autoloader

# Config nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Permissions sur le dossier storage
RUN chmod -R 777 public/storage logs

# Script de démarrage
COPY docker/start.sh /start.sh
RUN sed -i 's/\r//' /start.sh && chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
