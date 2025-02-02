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
