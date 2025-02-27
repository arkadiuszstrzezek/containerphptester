# Wybierz bazowy obraz PHP z obsługą Apache
FROM php:8.1-apache

# Zainstaluj zależności systemowe (w tym biblioteki do obsługi PostgreSQL)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Zainstaluj rozszerzenia PHP (PDO, PostgreSQL)
RUN docker-php-ext-install pdo pdo_pgsql

# Skopiuj pliki aplikacji do kontenera
COPY . /var/www/html/

# Ustaw właściciela plików na Apache
RUN chown -R www-data:www-data /var/www/html

# Udostępnij port 80
EXPOSE 80

# ENTRYPOINT wymusza uruchomienie startup.php podczas startu kontenera
ENTRYPOINT ["sh", "-c", "php /var/www/html/startup.php && apache2-foreground"]

# Uruchom worker (worker.php) jako główną komendę
CMD ["php", "/var/www/html/worker.php"]

