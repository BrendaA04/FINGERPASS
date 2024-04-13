<?php
include("conexion.php");

// Verificar si se recibe el id_documento por parámetro
if (isset($_GET['id_documento'])) {
    // Directorio donde se encuentran los documentos
    $directorio_documentos = "../documentacion/documentos/";

    // Obtener el id_documento desde el parámetro
    $id_documento = $_GET['id_documento'];

    // Realizar una consulta para obtener el nombre del archivo correspondiente al id_documento
    $consulta = mysqli_query($conexion, "SELECT documento, tipo_documento FROM documentos_ingreso WHERE id_documento = $id_documento");

    if ($fila = mysqli_fetch_assoc($consulta)) {
        // Obtiene el nombre del archivo y el tipo de documento
        $archivo = $fila['documento'];
        $tipo_documento = $fila['tipo_documento'];

        // Ruta completa del archivo
        $ruta_archivo = $directorio_documentos .'/'. $tipo_documento . '/' . $archivo;

        // Verificar que el archivo exista
        if (file_exists($ruta_archivo)) {
            // Encabezados para forzar la descarga del archivo
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=" . urlencode($archivo));
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . filesize($ruta_archivo));

            // Leer el archivo y enviarlo al cliente
            readfile($ruta_archivo);
            exit;
        } else {
            die("Error: El archivo no existe.");
        }
    } else {
        die("Error: No se encontró el registro del documento.");
    }
} else {
    die("Error: No se especificó el id_documento.");
}
?>
