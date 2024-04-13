<?php
// Conexión a la base de datos
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_documento']) && isset($_POST['verificacion'])) {
        $id_documento = $_POST['id_documento'];
        $verificacion = $_POST['verificacion'];

        if ($verificacion == 1) {
            // Actualizar verificación a 1 (paloma verde)
            $sql = "UPDATE documentos_ingreso SET verificacion = 1 , comentarios = 'validado' WHERE id_documento = '$id_documento'";
        } elseif ($verificacion == 2) {
            // Actualizar verificación a 2 (x roja) y agregar comentarios
            $comentarios = $_POST['comentarios'];
            $sql = "UPDATE documentos_ingreso SET verificacion = 2, comentarios = '$comentarios' WHERE id_documento = '$id_documento'";
        }

        if (mysqli_query($conexion, $sql)) {
            // Redireccionar a la página "documentacion.php" después de realizar la actualización
            header("Location: documentacion.php");
            exit();
        } else {
            echo "Error al actualizar la verificación y/o comentarios: " . mysqli_error($conexion);
        }
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
