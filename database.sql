-- Crear la base de datos
CREATE DATABASE sqli_lab;
USE sqli_lab;

-- Crear la tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    flag VARCHAR(100)
);

-- Insertar usuarios (uno con la flag)
INSERT INTO users (username, password, flag) VALUES ('admin', 'P@sSw0rD_S3gUr4_ImP0s1bl3', 'FLAG{sql_1nj3cti0n_m4st3r}');
INSERT INTO users (username, password, flag) VALUES ('juan', '1234', 'No hay flag para ti.');

-- Crear el usuario para la aplicación y darle permisos
CREATE USER 'dbuser'@'localhost' IDENTIFIED BY 'dbpassword';
GRANT ALL PRIVILEGES ON sqli_lab.* TO 'dbuser'@'localhost';
FLUSH PRIVILEGES;
