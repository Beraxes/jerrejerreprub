<?php
$servername = "";
$username = "gema";
$password = "gema123";
$dbname = "gemasas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tableCheckQuery = "SHOW TABLES LIKE 'user'";
$tableExistsResult = $conn->query($tableCheckQuery);

if ($tableExistsResult->num_rows == 0) {
    // Table does not exist, create it
    $createTableQuery = "CREATE TABLE user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255) DEFAULT NULL,
        apellido VARCHAR(255) DEFAULT NULL,
        email VARCHAR(255) NOT NULL,
        codigo VARCHAR(255) NOT NULL
    )";

    if ($conn->query($createTableQuery) === TRUE) {
        echo "Table 'user' created successfully.";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Table 'user' already exists.";
}

$conn->close();
?>