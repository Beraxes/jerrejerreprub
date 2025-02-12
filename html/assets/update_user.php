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
    $nombre = $_POST["nombre"] ?? null;
    $apellido = $_POST["apellido"] ?? null;
    $email = $_POST["email"] ?? null;
    $codigo = $_POST["codigo"] ?? null;
    $revisor_id = $_POST["revisor_id"] ?? null;

    if ($id) {
        updateUser($servername, $dbUsername, $dbPassword, $dbname, $id, $nombre, $apellido, $email, $codigo, $revisor_id);
    } else {
        echo json_encode(["status" => "error", "message" => "ID de usuario requerido"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>