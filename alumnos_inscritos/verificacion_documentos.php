<?php
session_start();

// Verificar si el usuario está autenticado
if (isset($_SESSION['matricula'])) {
    include "conexion.php";

    $matricula = $_SESSION['matricula'];
    
    // Consultar si hay algún documento con verificación igual a 2 para esta matrícula
    $sql = "SELECT COUNT(*) AS comentario FROM `comentarios_profesor_alumno` WHERE `matricula` = '$matricula' AND `verificacion` = 2";
    $result = $conexion->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['comentario'] > 0) {
            echo "tiene_comentario";
        }
    }

    $conexion->close();
}
?>
