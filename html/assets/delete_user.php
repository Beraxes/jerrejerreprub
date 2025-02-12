<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../db/db_functions.php';
$dbConfig = require '../db/db_config.php';

$servername = $dbConfig['servername'];
$dbUsername = $dbConfig['dbUsername'];
$dbPassword = $dbConfig['dbPassword'];
$dbname = $dbConfig['dbname'];

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"] ?? null;

    if (!$id) {
        echo json_encode(["status" => "error", "message" => "ID de usuario no proporcionado"]);
        exit;
    }

    echo deleteUser($servername, $dbUsername, $dbPassword, $dbname, $id);
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
