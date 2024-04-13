<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['matricula']) && isset($_POST['asistencia'])) {
    $matricula = $_POST['matricula'];
    $asistencia = $_POST['asistencia'];

    // Realizar la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "12345";
    $database = "efi100cia2";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar si la conexión fue exitosa
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Actualizar el estado de asistencia en la base de datos
    $sql_actualizar_asistencia = "UPDATE asistencia_alumno SET asistencia = '$asistencia' WHERE matricula = $matricula";

    if ($conn->query($sql_actualizar_asistencia) === TRUE) {
        echo "Asistencia actualizada correctamente";
    } else {
        echo "Error al actualizar la asistencia: " . $conn->error;
    }

    if ($conn->query($sql_actualizar_asistencia) === FALSE) {
        echo "Asistencia actualizada correctamente";
    } else {
        echo "Error al actualizar la asistencia: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "Error: Datos de asistencia no recibidos correctamente";
}
?>