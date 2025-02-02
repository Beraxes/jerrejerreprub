<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivo CSV - Sistema de Gestión de Usuarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Gestión de Usuarios</h1>
        
        <div class="upload-instructions">
            <h3>Instrucciones para subir el archivo:</h3>
            <p>El archivo CSV debe contener las siguientes columnas:</p>
            <ul>
                <li>Email</li>
                <li>Nombre</li>
                <li>Apellido</li>
                <li>Código (1: Activo, 2: Inactivo, 3: En Espera)</li>
            </ul>
        </div>

        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" accept=".csv" required>
            <button type="submit">Procesar Archivo</button>
        </form>
    </div>
</body>
</html>