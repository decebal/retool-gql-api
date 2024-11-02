# Stage 1: Build dependencies
FROM php:8.3-fpm AS builder

# Install system dependencies only needed for building
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . /var/www

# Install PHP dependencies with Composer, optimized for production
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Stage 2: Production environment
FROM php:8.3-fpm

# Copy only necessary extensions and PHP libraries
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy the built application from the builder stage
COPY --from=builder /var/www /var/www

# Set working directory
WORKDIR /var/www

# Expose port (optional if the web server will be separate)
EXPOSE 9000
