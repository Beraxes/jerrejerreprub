function editUser(id) {
    document.getElementById('edit_' + id).style.display = 'none';
    document.getElementById('save_' + id).style.display = 'inline-block';
    document.getElementById('cancel_' + id).style.display = 'inline-block';
    document.getElementById('status_' + id).style.display = 'inline-block'; // Mostrar el menú de estado

    let nombre = document.getElementById('nombre_' + id);
    let apellido = document.getElementById('apellido_' + id);
    let email = document.getElementById('email_' + id);

    if (nombre) nombre.removeAttribute('readonly');
    if (apellido) apellido.removeAttribute('readonly');
    if (email) email.removeAttribute('readonly');
}

function saveUser(id) {
    let nombre = document.getElementById('nombre_' + id).value;
    let apellido = document.getElementById('apellido_' + id).value;
    let email = document.getElementById('email_' + id).value;
    let status = document.getElementById('status_' + id).value; // Obtener el estado numérico seleccionado

    fetch('../assets/update_user.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}&nombre=${encodeURIComponent(nombre)}&apellido=${encodeURIComponent(apellido)}&email=${encodeURIComponent(email)}&codigo=${encodeURIComponent(status)}`
    })
    .then(response => response.text())
    .then(text => {
        console.log("Respuesta del servidor:", text);
        return JSON.parse(text);
    })
    .then(data => {
        if (data.status === "success") {
            cancelEdit(id);
            alert("Usuario actualizado correctamente");
            location.reload();
        } else {
            alert("Error al actualizar: " + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function cancelEdit(id) {
    document.getElementById('edit_' + id).style.display = 'inline-block';
    document.getElementById('save_' + id).style.display = 'none';
    document.getElementById('cancel_' + id).style.display = 'none';
    document.getElementById('status_' + id).style.display = 'none'; // Ocultar el menú de estado

    let nombre = document.getElementById('nombre_' + id);
    let apellido = document.getElementById('apellido_' + id);
    let email = document.getElementById('email_' + id);

    if (nombre) nombre.setAttribute('readonly', true);
    if (apellido) apellido.setAttribute('readonly', true);
    if (email) email.setAttribute('readonly', true);
}

function deleteUser(id) {
    if (!confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        return;
    }

    fetch('../assets/delete_user.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}`
    })
    .then(response => response.text()) 
    .then(text => {
        console.log("Respuesta del servidor:", text); 
        return JSON.parse(text);
    })
    .then(data => {
        if (data.status === "success") {
            alert("Usuario eliminado correctamente");
            location.reload(); // Recargar la página para actualizar la lista de usuarios
        } else {
            alert("Error al eliminar el usuario: " + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}