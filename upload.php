<?php

// Include the database functions
require 'db/db_functions.php'; // Assuming you save the earlier functions here
$dbConfig = require 'db/db_config.php';

// Extract database credentials
$servername = $dbConfig['servername'];
$dbUsername = $dbConfig['dbUsername'];
$dbPassword = $dbConfig['dbPassword'];
$dbname = $dbConfig['dbname'];

// File upload logic
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if the file already exists
if (file_exists($target_file)) {
    echo "Archivo ya existe.\n";
    $uploadOk = 0;
}

// If there were no upload errors, move the file
if ($uploadOk === 0) {
    echo "\nEl archivo no fue subido.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "El archivo " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " fue subido.";
    } else {
        echo "Hubo un error subiendo el archivo.";
    }
}

// Initialize user arrays
$usuarios_activos = [];
$usuarios_inactivos = [];
$usuarios_espera = [];
$usuarios_invalidos = [];

// Open the file and process it
if (($handle = fopen($target_file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",", '"', '\\')) !== FALSE) {
        $email = trim($data[0]);
        $nombre = isset($data[1]) ? trim($data[1]) : "";
        $apellido = isset($data[2]) ? trim($data[2]) : "";
        $codigo = isset($data[3]) ? trim($data[3]) : "";

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            continue; // Skip invalid emails
        }

        // Register user if email doesn't exist
        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
        if (!emailExists($conn, $email)) {
            // Add user to the database
            if ($codigo >= 1 && $codigo <= 3) {
                registerUser($servername, $dbUsername, $dbPassword, $dbname, $nombre, $apellido, $email, $codigo);
            }
        }
        $conn->close();

        $usuario = ["email" => $email, "nombre" => $nombre, "apellido" => $apellido, "codigo" => $codigo];

        // Classify the user based on codigo
        switch ($codigo) {
            case "1":
                $usuarios_activos[] = $usuario;
                break;
            case "2":
                $usuarios_inactivos[] = $usuario;
                break;
            case "3":
                $usuarios_espera[] = $usuario;
                break;
            default:
                $usuarios_invalidos[] = $usuario;
                break;
        }
    }
    fclose($handle);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Procesados</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Usuarios Activos</h2>
    <table>
        <tr>
            <th>Email</th>
            <th>Nombre</th>
            <th>Apellido</th>
        </tr>
        <?php foreach ($usuarios_activos as $usuario) { ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["apellido"]); ?></td>
            </tr>
        <?php } ?>
    </table>

    <h2>Usuarios Inactivos</h2>
    <table>
        <tr>
            <th>Email</th>
            <th>Nombre</th>
            <th>Apellido</th>
        </tr>
        <?php foreach ($usuarios_inactivos as $usuario) { ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["apellido"]); ?></td>
            </tr>
        <?php } ?>
    </table>

    <h2>Usuarios en Espera</h2>
    <table>
        <tr>
            <th>Email</th>
            <th>Nombre</th>
            <th>Apellido</th>
        </tr>
        <?php foreach ($usuarios_espera as $usuario) { ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["apellido"]); ?></td>
            </tr>
        <?php } ?>
    </table>

    <h2 class="error">Usuarios con Formato Inválido</h2>
    <p class="error">Algunos registros tienen un código inválido. Formato correcto: <strong>Email, Nombre, Apellido, Código (1, 2 o 3)</strong></p>
    <table>
        <tr>
            <th>Email</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Código</th>
        </tr>
        <?php foreach ($usuarios_invalidos as $usuario) { ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["apellido"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["codigo"]); ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
