FROM php:8.1-apache

# Konfigurasi Apache port binding untuk Render ($PORT environment variable)
RUN sed -i 's/80/${PORT:-80}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
RUN a2enmod rewrite

# Copy seluruh kodingan ke web root
COPY . /var/www/html/

WORKDIR /var/www/html

EXPOSE 80
