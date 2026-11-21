# Dockerfile untuk Deployment Render.com (PHP Apache + MySQL Client)
FROM php:8.1-apache

# Install ekstensi PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Copy seluruh kodingan ke web root
COPY . /var/www/html/

# Port standar Cloud Web Service
EXPOSE 80
