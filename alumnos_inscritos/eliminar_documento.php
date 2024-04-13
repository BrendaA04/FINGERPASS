<?php
// Primero, asegúrate de obtener el valor del id_documento que se desea eliminar.
// Puedes recibirlo desde un formulario o a través de una solicitud AJAX, por ejemplo.
if (isset($_GET['id_documento'])) {
    $id_documento = $_GET['id_documento'];
    
    // Luego, conecta con tu base de datos (asumiendo que estás usando MySQL)
    include "conexion.php";

    // Ahora, realiza la sentencia SQL para eliminar el registro por su id_documento
    $sql = "DELETE FROM documentos_ingreso WHERE `documentos_ingreso`.`id_documento` = $id_documento";

    if ($conexion->query($sql) === TRUE) {
        echo "El registro con id_documento $id_documento ha sido eliminado correctamente.";
        header("refresh:2;url=documentacion.php");

    } else {
        echo "Error al eliminar el registro: " . $conexion->error;
    }

    // Cierra la conexión con la base de datos
    $conexion->close();
}
?>
