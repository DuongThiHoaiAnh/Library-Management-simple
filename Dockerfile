# ==========================================
# Dockerfile Laravel 1-stage (Render-optimized)
# ==========================================
FROM php:8.2-cli

# Cài đặt dependencies hệ thống + PHP extensions
RUN apt-get update && apt-get install -y \
    git curl unzip zip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo_mysql gd zip bcmath \
  && rm -rf /var/lib/apt/lists/*

# Cài composer toàn cục
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy toàn bộ mã nguồn (bao gồm artisan)
COPY . .

# Cài đặt dependencies (tắt scripts để tránh lỗi artisan chưa setup)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts \
 && composer dump-autoload --optimize \
 && php artisan package:discover --ansi || true

# Quyền truy cập storage + cache
RUN chmod -R 775 storage bootstrap/cache || true

# Thiết lập biến môi trường
ENV APP_ENV=production
ENV PORT=8000

EXPOSE 8000

# Lệnh khởi động
CMD sh -lc '\
  if [ -z "${APP_KEY}" ]; then php artisan key:generate --ansi || true; fi && \
  php artisan storage:link || true && \
  php artisan migrate --force || true && \
  php artisan serve --host=0.0.0.0 --port=${PORT:-8000} \
'

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql
