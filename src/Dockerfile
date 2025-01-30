FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_pgsql

RUN groupadd -g 1000 myuser && \
    useradd -u 1000 -g myuser -m myuser

WORKDIR /var/www

COPY . .

RUN chown -R myuser:myuser /var/www

USER myuser

CMD ["php-fpm"]
