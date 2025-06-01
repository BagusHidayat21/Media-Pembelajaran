FROM php:8.1-apache

# Copy semua file ke container
COPY . /var/www/html/

# Aktifkan mod_rewrite jika perlu
RUN a2enmod rewrite

# Ubah permission (opsional)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
