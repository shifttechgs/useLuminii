# 🐘 Base image — PHP 8.4 with FPM
FROM php:8.4-fpm

# -------------------------------
# 1️⃣ Install system dependencies
# -------------------------------
RUN apt-get update && apt-get install -y \
    git curl zip unzip nano netcat-openbsd \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# -------------------------------
# 2️⃣ Install Composer globally
# -------------------------------
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# -------------------------------
# 3️⃣ (Optional) Install Node & npm for Vite builds
# -------------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# -------------------------------
# 4️⃣ Set working directory
# -------------------------------
WORKDIR /var/www

# -------------------------------
# 5️⃣ Create required directories and set permissions
# -------------------------------
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# -------------------------------
# 6️⃣ Copy PHP-FPM configuration
# -------------------------------
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# -------------------------------
# 7️⃣ Copy and setup entrypoint script
# -------------------------------
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# -------------------------------
# 🔟 Expose port & start PHP-FPM
# -------------------------------
EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
