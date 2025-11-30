FROM bajiou/farm-info-app:latest AS app-built

FROM nginx:1.27-alpine

WORKDIR /var/www/html

COPY src/public ./public

COPY --from=app-built /var/www/html/public/build ./public/build

COPY docker-config/nginx/prod.conf /etc/nginx/conf.d/default.conf
