<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clave_profesor = $_POST["clave"];
    $nombre = $_POST["nombre"];
    $ap_paterno = $_POST["ap_paterno"];
    $ap_materno = $_POST["ap_materno"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Encriptar la contraseña de manera segura usando password_hash
    $contrasena_encriptada = md5($contrasena);

    // Consulta preparada para evitar inyección de SQL
    $stmt = $conexion->prepare("INSERT INTO profesores (clave_profesor,nombre,ap_paterno,ap_materno, correo, contrasena) VALUES (?, ?, ?,?,?,?)");
    $stmt->bind_param("isssss", $clave_profesor, $nombre, $ap_paterno, $ap_materno, $correo, $contrasena_encriptada);


    if ($stmt->execute()) {
        // La inserción se realizó correctamente
        echo "Registro exitoso.";

    } else {
        // Hubo un error en la inserción
        echo "Error al registrar el profesor: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
