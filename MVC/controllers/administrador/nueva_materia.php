<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];

    

    // Consulta preparada para evitar inyección de SQL
    $stmt = $conexion->prepare("INSERT INTO asignaturas (nombre) VALUES (?)");
    $stmt->bind_param("s", $nombre);

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
