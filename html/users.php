<?php
require('./db/db_functions.php');
$dbConfig = require 'db/db_config.php';

$servername = $dbConfig['servername'];
$dbUsername = $dbConfig['dbUsername'];
$dbPassword = $dbConfig['dbPassword'];
$dbname = $dbConfig['dbname'];

$usuarios = fetchUsers($servername, $dbUsername, $dbPassword, $dbname);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="./assets/styles.css">
    <script src="./assets/users.js"></script>
</head>
<body>
<button onclick="window.location.href='/';" class="secondary">Volver</button>
    <h2>Usuarios Activos</h2>
    <table>
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Email</th>
        <th>Revisor</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($usuarios["activos"] as $user) { ?>
        <tr>
            <td><?= htmlspecialchars($user["id"]) ?></td>
            <td><input type="text" id="nombre_<?= $user["id"] ?>" value="<?= htmlspecialchars($user["nombre"]) ?>" readonly></td>
            <td><input type="text" id="apellido_<?= $user["id"] ?>" value="<?= htmlspecialchars($user["apellido"]) ?>" readonly></td>
            <td><input type="text" id="email_<?= $user["id"] ?>" value="<?= htmlspecialchars($user["email"]) ?>" readonly></td>
            <td><?= htmlspecialchars($user["revisor"]) ?></td> <!-- Mostrar nombre del revisor -->
            <td class="actions">
                <button class="edit" id="edit_<?= $user["id"] ?>" onclick="editUser(<?= $user['id'] ?>)">Editar</button>
                <button class="save" id="save_<?= $user["id"] ?>" onclick="saveUser(<?= $user['id'] ?>)" style="display:none;">Guardar</button>
                <button class="cancel" id="cancel_<?= $user["id"] ?>" onclick="cancelEdit(<?= $user['id'] ?>)" style="display:none;">Cancelar</button>
                <select class="status" id="status_<?= $user["id"] ?>" style="display:none;">
                    <?php
                    $codigo = $user['codigo']?? 1;
                    ?>
                    <option value="1" <?= $codigo == 1 ? 'selected' : '' ?>>Activo</option>
                    <option value="2" <?= $codigo == 2 ? 'selected' : '' ?>>Inactivo</option>
                    <option value="3" <?= $codigo == 3 ? 'selected' : '' ?>>En espera</option>
                </select>
                <button class="delete" id="delete_<?= $user["id"] ?>" onclick="deleteUser(<?= $user['id'] ?>)">Eliminar</button>
            </td>
        </tr>
    <?php } ?>
</table>

    <h2>Usuarios Inactivos</h2>
    <table>
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Email</th>
        <th>Revisor</th>
        <th>Acciones</th>
    </tr>
        <?php foreach ($usuarios["inactivos"] as $user) { ?>
            <tr>
            <td><?= htmlspecialchars($user["id"]) ?></td>
            <td><input type="text" id="nombre_<?= $user["id"] ?>" value="<?= htmlspecialchars($user["nombre"]) ?>" readonly></td>
            <td><input type="text" id="apellido_<?= $user["id"] ?>" value="<?= htmlspecialchars($user["apellido"]) ?>" readonly></td>
            <td><input type="text" id="email_<?= $user["id"] ?>" value="<?= htmlspecialchars($user["email"]) ?>" readonly></td>
            <td><?= htmlspecialchars($user["revisor"]) ?></td> <!-- Mostrar nombre del revisor -->
            <td class="actions">
                <button class="edit" id="edit_<?= $user["id"] ?>" onclick="editUser(<?= $user['id'] ?>)">Editar</button>
                <button class="save" id="save_<?= $user["id"] ?>" onclick="saveUser(<?= $user['id'] ?>)" style="display:none;">Guardar</button>
                <button class="cancel" id="cancel_<?= $user["id"] ?>" onclick="cancelEdit(<?= $user['id'] ?>)" style="display:none;">Cancelar</button>
                <select class="status" id="status_<?= $user["id"] ?>" style="display:none;">
                    <?php
                    $codigo = $user['codigo']?? 1;
                    ?>
                    <option value="1" <?= $codigo == 1 ? 'selected' : '' ?>>Activo</option>
                    <option value="2" <?= $codigo == 2 ? 'selected' : '' ?>>Inactivo</option>
                    <option value="3" <?= $codigo == 3 ? 'selected' : '' ?>>En espera</option>
                </select>
                <button class="delete" id="delete_<?= $user["id"] ?>" onclick="deleteUser(<?= $user['id'] ?>)">Eliminar</button>
            </td>
        </tr>
        <?php } ?>
    </table>

    <h2>Usuarios en Espera</h2>
    <table>
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Email</th>
        <th>Revisor</th>
        <th>Acciones</th>
    </tr>
        <?php foreach ($usuarios["espera"] as $user) { ?>
            <tr>
            <td><?= htmlspecialchars($user["id"]) ?></td>
            <td><input type="text" id="nombre_<?= $user["id"] ?>" value="<?= htmlspecialchars($user["nombre"]) ?>" readonly></td>
            <td><input type="text" id="apellido_<?= $user["id"] ?>" value="<?= htmlspecialchars($user["apellido"]) ?>" readonly></td>
            <td><input type="text" id="email_<?= $user["id"] ?>" value="<?= htmlspecialchars($user["email"]) ?>" readonly></td>
            <td><?= htmlspecialchars($user["revisor"]) ?></td> <!-- Mostrar nombre del revisor -->
            <td class="actions">
                <button class="edit" id="edit_<?= $user["id"] ?>" onclick="editUser(<?= $user['id'] ?>)">Editar</button>
                <button class="save" id="save_<?= $user["id"] ?>" onclick="saveUser(<?= $user['id'] ?>)" style="display:none;">Guardar</button>
                <button class="cancel" id="cancel_<?= $user["id"] ?>" onclick="cancelEdit(<?= $user['id'] ?>)" style="display:none;">Cancelar</button>
                <select class="status" id="status_<?= $user["id"] ?>" style="display:none;">
                    <?php
                    $codigo = $user['codigo']?? 1;
                    ?>
                    <option value="1" <?= $codigo == 1 ? 'selected' : '' ?>>Activo</option>
                    <option value="2" <?= $codigo == 2 ? 'selected' : '' ?>>Inactivo</option>
                    <option value="3" <?= $codigo == 3 ? 'selected' : '' ?>>En espera</option>
                </select>
                <button class="delete" id="delete_<?= $user["id"] ?>" onclick="deleteUser(<?= $user['id'] ?>)">Eliminar</button>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
