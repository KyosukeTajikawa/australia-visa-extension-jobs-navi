# まず、ビルド済み app イメージを持ってくるステージ
FROM bajiou/farm-info-app:latest AS app-built

# 本番 nginx イメージ
FROM nginx:1.27-alpine

WORKDIR /var/www/html

# public 以下（index.php とか画像とか）はリポジトリからコピー
COPY ./src/public ./public

# app イメージの中の public/build をそのままコピー
COPY --from=app-built /var/www/html/public/build ./public/build

# nginx の設定
COPY ./docker-config/nginx/default.conf /etc/nginx/conf.d/default.conf
