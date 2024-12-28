FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Set the working directory
WORKDIR /var/www

# Copy the Laravel project files
COPY . /var/www

# Install Composer (for PHP package management)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install project dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Expose port 80
EXPOSE 80

# Start the PHP server
CMD ["php-fpm"]
