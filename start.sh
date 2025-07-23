#!/bin/bash

# Iniciar el servicio de la base de datos en segundo plano
/etc/init.d/mariadb start

# Esperar un poco para que el servicio esté listo
sleep 5

# Importar el script SQL para crear la base de datos y los usuarios
mysql -u root < /tmp/database.sql

# Iniciar Apache en primer plano para mantener el contenedor activo
apache2ctl -D FOREGROUND
