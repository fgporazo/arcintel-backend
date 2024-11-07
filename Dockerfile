# Use PHP 8.2 FPM image as the base
FROM php:8.2-fpm

# Update and install base dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev  # Add this line to install the Oniguruma library

# Install dependencies for gd extension (libpng, libjpeg, libfreetype)
RUN apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev

# Configure and install gd extension with FreeType and JPEG support
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install other PHP extensions (mbstring, zip)
RUN docker-php-ext-install mbstring zip

# Clean up apt cache to reduce image size
RUN rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Set permissions (optional)
RUN chown -R www-data:www-data /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Expose port 8000 for PHP's built-in server (or use port 80 if running a web server like Nginx)
EXPOSE 8000

# Run Laravel's artisan server
CMD php artisan serve --host=0.0.0.0 --port=8000