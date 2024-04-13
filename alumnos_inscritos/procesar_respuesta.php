<?php
session_start();

if (isset($_SESSION['matricula'])) {
    $matricula = $_SESSION['matricula'];
} else {
    echo "Datos no encontrados";
    header('Location: index_padre_de_familia.html');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $respuesta = $_POST['respuesta'];
    // Obtener los datos del formulario
    $respuesta = $_POST['respuesta'];
    $id_grupo = $_POST['id_grupo'];
    $id_asignatura = $_POST['id_asignatura'];
    $comentario = $_POST['comentario'];
    $profesor = $_POST['profesor'];
    $clave_profesor = $_POST['clave_profesor']; // Obtener la clave del profesor del formulario

    // Incluir archivo de conexión a la base de datos
    include "conexion.php";

    // Preparar y ejecutar la consulta para insertar la respuesta en la tabla
    $stmt = $conexion->prepare("INSERT INTO respuestas_profesor_alumno (clave_profesor, matricula, id_asignatura, id_grupo, respuesta) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $clave_profesor, $matricula, $id_asignatura, $id_grupo, $respuesta); // Agregar la clave del profesor como primer parámetro

    if ($stmt->execute()) {
        echo "Respuesta enviada correctamente";
    } else {
        echo "Error al enviar la respuesta: " . $conexion->error;
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conexion->close();

} else {
    echo "Acceso no válido";
}
?>
