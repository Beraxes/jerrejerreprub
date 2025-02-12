<?php

function emailExists($conn, $email) {
    $checkEmailStmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $result = $checkEmailStmt->get_result();
    $checkEmailStmt->close();

    return $result->num_rows > 0;
}

function registerUser($servername, $username, $password, $dbname, $nombre, $apellido, $email, $codigo) {
    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind for registration
    $stmt = $conn->prepare("INSERT INTO user (nombre, apellido, email, codigo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nombre, $apellido, $email, $codigo);

    // Attempt to execute the statement
    if ($stmt->execute() === TRUE) {
        echo '<script> console.log("User registered successfully.")</script>';
    } else {
        echo "Error: " . $stmt->error . "<br>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

function fetchUsers($servername, $username, $password, $dbname) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM user WHERE codigo IN (1, 2, 3)";
    $result = $conn->query($sql);

    $usuarios = [
        "activos" => [],
        "inactivos" => [],
        "espera" => []
    ];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuario = [

                "id" => $row["id"],
                "nombre" => $row["nombre"],
                "apellido" => $row["apellido"],
                "email" => $row["email"]
            ];

            switch ($row["codigo"]) {
                case 1:
                    $usuarios["activos"][] = $usuario;
                    break;
                case 2:
                    $usuarios["inactivos"][] = $usuario;
                    break;
                case 3:
                    $usuarios["espera"][] = $usuario;
                    break;
            }
        }
    }

    $conn->close();

    return $usuarios;
}

function updateUser($servername, $username, $password, $dbname, $id, $nombre = null, $apellido = null, $email = null, $codigo = null) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo json_encode(["status" => "error", "message" => "Error de conexión: " . $conn->connect_error]);
        exit;
    }

    // Construir consulta dinámicamente
    $fields = [];
    $params = [];
    $types = "";

    if ($nombre !== null) {
        $fields[] = "nombre = ?";
        $params[] = $nombre;
        $types .= "s";
    }
    if ($apellido !== null) {
        $fields[] = "apellido = ?";
        $params[] = $apellido;
        $types .= "s";
    }
    if ($email !== null) {
        $fields[] = "email = ?";
        $params[] = $email;
        $types .= "s";
    }
    if ($codigo !== null) {
        $fields[] = "codigo = ?";
        $params[] = $codigo;
        $types .= "i";
    }

    // Si no hay campos para actualizar, salimos
    if (empty($fields)) {
        echo json_encode(["status" => "error", "message" => "No hay datos para actualizar"]);
        exit;
    }

    $query = "UPDATE user SET " . implode(", ", $fields) . " WHERE id = ?";
    $params[] = $id;
    $types .= "i";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Error en la preparación de la consulta"]);
        exit;
    }

    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Usuario actualizado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar el usuario"]);
    }

    $stmt->close();
    $conn->close();
}
?>