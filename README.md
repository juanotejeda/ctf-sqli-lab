# README.txt — SQL Injection CTF Lab – Remote Execution

## Descripción

Bienvenido/a al laboratorio **SQL Injection CTF** desarrollado por la comunidad #RemoteExecution.
Este entorno está diseñado con fines educativos para practicar y demostrar técnicas de ataque y defensa frente a vulnerabilidades de inyección SQL en aplicaciones web reales.

> **Importante:**
> Todo el entorno corre en un contenedor Docker aislado y seguro.
> Uso prohibido para propósitos ilícitos fuera del laboratorio.

## Requisitos
- Docker instalado (Linux, Windows, Mac)
- Acceso a terminal/Consola

## Instalación y Ejecución
1. **Clona o descarga el contenido del proyecto:**
git clone https://github.com/juanotejeda/ctf-sqli-lab.git
cd ctf-sqli-lab

2. **Construye la imagen Docker:**
sudo docker build -t ctf-sqli .

3. **Lanza el laboratorio:**
sudo docker run -d -p 8080:80 --name ctf-sqli ctf-sqli

4. **Accede desde tu navegador a:**
http://localhost:8080

## Objetivo del Reto
- Lograr iniciar sesión como el usuario **admin** explotando una vulnerabilidad de inyección SQL en el panel de acceso.
- Al hacerlo correctamente, obtendrás la **flag** secreta como validación de tu éxito.


## Payloads de Ejemplo
Prueba estos valores en el campo **usuario** para el bypass de autenticación (campo contraseña puede quedar en blanco):
- `admin' -- `
- `admin' #`
- `admin' or '1'='1`
- `' or 1=1--`

Consulta la landing [¿Qué es SQL Injection?](about-sqli.php) para una explicación de la lógica y más ejemplos.

## Reinicio y Detención del Laboratorio
- **Detener el contenedor:**
sudo docker stop ctf-sqli

- **Eliminar el contenedor:**
sudo docker rm ctf-sqli

## Problemas comunes
- Si el puerto 8080 está ocupado, cámbialo por otro disponible, por ejemplo:
sudo docker run -d -p 8085:80 --name ctf-sqli ctf-sqli
Y accede por `http://localhost:8085`

- Si haces modificaciones, vuelve a construir la imagen antes de relanzar el contenedor.


## Créditos
- Desarrollado por **Juano.exe** para la comunidad #RemoteExecution
- Contacto: [juanotejeda@gmail.com](mailto:juanotejeda@gmail.com)
- Grettings: HielaSangre - NinjaThor - Alejandro Hatz - Pombe - Pipo

## Uso y Licencia

- **Exclusivo para formación, docencia y pruebas controladas de ciberseguridad.**
- **Prohibido el uso en sistemas de terceros sin autorización.**



¡Mucha suerte y Happy Hunting!
