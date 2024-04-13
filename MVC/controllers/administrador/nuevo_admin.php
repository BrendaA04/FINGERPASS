<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Encriptar la contraseña de manera segura usando password_hash
    $contrasena_encriptada = md5($contrasena);

    // Consulta preparada para evitar inyección de SQL
    $stmt = $conexion->prepare("INSERT INTO administrador (nombre, correo, contrasena) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $correo, $contrasena_encriptada);

    if ($stmt->execute()) {
        // La inserción se realizó correctamente
        echo "Registro exitoso.";
    } else {
        // Hubo un error en la inserción
        echo "Error al registrar el administrador: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
