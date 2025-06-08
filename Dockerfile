FROM php:8.1-apache

# Install ekstensi mysqli, pdo_mysql, dan dependensi yang dibutuhkan
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# Aktifkan mod_rewrite untuk .htaccess
RUN a2enmod rewrite

# Copy konfigurasi php.ini khusus ke container
COPY php.ini /usr/local/etc/php/

# Copy semua file ke direktori web server
COPY . /var/www/html/

# Ubah permission agar bisa dibaca Apache (opsional tapi disarankan)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 untuk Render
EXPOSE 80
