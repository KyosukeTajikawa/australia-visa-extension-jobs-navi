FROM php:8.3-fpm AS app-base

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libicu-dev libonig-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip intl gd bcmath \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY src/composer.json src/composer.lock ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress \
    --no-scripts

COPY src /var/www/html

RUN rm -f .env

RUN php artisan config:clear || true \
    && rm -f public/hot

RUN mkdir -p storage/logs \
    && touch storage/logs/laravel.log \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

FROM node:20 AS node-build
WORKDIR /var/www/html

COPY src/package*.json ./
COPY src/tsconfig*.json ./
COPY src/vite.config.* ./
COPY src/resources ./resources
COPY src/public ./public
COPY src/.env.production ./.env.production

RUN npm ci
RUN npm run build   # => public/build 生成

# ----- 最終 app イメージ -----
FROM app-base AS final
WORKDIR /var/www/html

COPY --from=node-build /var/www/html/public/build ./public/build

CMD ["php-fpm"]
