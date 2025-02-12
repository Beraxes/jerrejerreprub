<?php
$dbConfig = require 'db/db_config.php';

$servername = $dbConfig['servername'];
$dbUsername = $dbConfig['dbUsername'];
$dbPassword = $dbConfig['dbPassword'];
$dbname = $dbConfig['dbname'];

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tableCheckQuery = "SHOW TABLES LIKE 'revisores'";
$tableExistsResult = $conn->query($tableCheckQuery);

if ($tableExistsResult->num_rows == 0) {
    $createTableQuery = "CREATE TABLE revisores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(45) DEFAULT NULL,
        apellido VARCHAR(45) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    if ($conn->query($createTableQuery) === TRUE) {
        echo '<script>console.log("Table revisores created successfully.")</script>';
    } else {
        echo '<script>console.error("ERROR: ' . addslashes($conn->error) . '");</script>';
    }
} else {
    echo '<script>console.log("Table revisores already exists.")</script>';
}

$tableCheckQuery = "SHOW TABLES LIKE 'user'";
$tableExistsResult = $conn->query($tableCheckQuery);

if ($tableExistsResult->num_rows == 0) {
    $createTableQuery = "CREATE TABLE user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255) DEFAULT NULL,
        apellido VARCHAR(255) DEFAULT NULL,
        email VARCHAR(255) NOT NULL,
        codigo VARCHAR(255) NOT NULL,
        revisor_id INT,
        FOREIGN KEY (revisor_id) REFERENCES revisores(id)
    )";

    if ($conn->query($createTableQuery) === TRUE) {
        echo '<script>console.log("Table user created successfully.")</script>';
    } else {
        echo '<script>console.error("ERROR: ' . addslashes($conn->error) . '");</script>';
    }
} else {
    echo '<script>console.log("Table user already exists.")</script>';
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivo CSV - Sistema de Gestión de Usuarios</title>
    <link rel="stylesheet" href="assets/styles.css">
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
            <button class="primary" type="submit">Procesar Archivo</button>
        </form>
        <p>Usuarios Registrados en la Base de datos: </p>
        <button type="button" class="secondary" onclick="window.location.href='users.php'">Ver Usuarios</button>
    </div>
</body>
</html>