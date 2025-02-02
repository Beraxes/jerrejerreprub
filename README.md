## Requisitos Generales
 [Docker Desktop](https://www.docker.com/products/docker-desktop/)
 Si no tienes docker puedes usar una alternativa que tenga una base de datos mysql y una aplicacion como xamp o laragon para los archivos dentro de la carpeta html. Sin embargo recomiendo el uso de docker para asegurar la consistencia.
Los puertos 3306 y 8080 no deben estar en uso.

**Pasos a seguir:**

 1. *En la carpeta del proyecto abrir una terminal o consola y ejecutar `docker compose build && docker compose up -d` este paso arrancara el servicio de nginix con soporte para php.
 2. *Abrimos la carpeta html y dentro creamos una nueva carpeta con el nombre `uploads`, luego abrimos una terminal y haremos un `chmod 777 uploads` este paso es para dar permisos a la carpeta de lectura, escritura y ejecucion.
 3. *Nos dirigimos la carpeta db y haremos lo mismo del primer paso `docker compose build && docker compose up -d` este paso arrancara el servicio de Mysql
 4. En el archivo db_config.php modificamos la linea 'servername' => 'localhost' y remplazamos localhost por la ip de nuestra computador.
 5. *Abrimos el archivo createTable.php y modificamos $servername =  ""; y dentro de las comillas pondremos la ip de nuestro computador.
 6. *Abrimos localhost:8080/createTable.php para crear la tabla en la base de datos automaticamente.
 7. Dirigirnos a localhost:8080 y subir el archivo a procesar.
 8. (Opcional) Descargar o usar un software para las gestion de bases de datos ejemplo [Dbeaver](https://dbeaver.io/download/)
 9. Para conectarnos con Mysql en dbeaver usaremos la url: `jdbc:mysql://localhost:3306/gemasas?allowPublicKeyRetrieval=true&useSSL=false`, usuario y contraseña estan en el archivo docker-compose.yml
