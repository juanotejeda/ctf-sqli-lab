#RE Ciberlabs
# Dockerfile para Laboratorio de SQL Injection
FROM debian:stable-slim

# Instala Apache, PHP, MariaDB (MySQL) y el conector de PHP para la BD
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    apache2 \
    php \
    libapache2-mod-php \
    mariadb-server \
    php-mysql \
    && rm -rf /var/lib/apt/lists/*

# Elimina la página por defecto de Apache
RUN rm /var/www/html/index.html

# Copia los archivos de la aplicación web y el logo
COPY index.php /var/www/html/
COPY login.php /var/www/html/
COPY image.jpg /var/www/html/

# Copia el script de la base de datos y el de inicio
COPY database.sql /tmp/
COPY start.sh /

# Da permisos de ejecución al script de inicio
RUN chmod +x /start.sh

# Expone el puerto 80 para acceder a la web
EXPOSE 80

# Comando que se ejecutará al iniciar el contenedor
CMD ["/start.sh"]
