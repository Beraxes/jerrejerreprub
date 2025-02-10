## Requisitos Generales
 [Docker Desktop](https://www.docker.com/products/docker-desktop/)
 Si no tienes docker puedes usar una alternativa que tenga una base de datos mysql y una aplicacion como xamp o laragon para los archivos dentro de la carpeta html. Sin embargo recomiendo el uso de docker para asegurar la consistencia.
Los puertos 3306 y 8080 no deben estar en uso.

**Pasos a seguir:**

 1. *En la carpeta del proyecto abrir una terminal o consola y ejecutar `docker compose build && docker compose up -d` este paso arrancara el servicio de nginix con soporte para php y Servicio de Mysql.
 2. *Abrimos localhost:8080/createTable.php para crear la tabla en la base de datos automaticamente.
 3. Dirigirnos a localhost:8080 y subir el archivo a procesar.
 4. (Opcional) Descargar o usar un software para las gestion de bases de datos ejemplo [Dbeaver](https://dbeaver.io/download/)
 5. Para conectarnos con Mysql en dbeaver usaremos la url: `jdbc:mysql://localhost:3306/gemasas?allowPublicKeyRetrieval=true&useSSL=false`, usuario y contraseña estan en el archivo docker-compose.yml
