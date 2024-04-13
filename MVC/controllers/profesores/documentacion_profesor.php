<?php
// Iniciar sesión si aún no está iniciada
session_start();

// Verificar si se ha iniciado sesión como profesor y obtener su clave de profesor
if (isset($_SESSION['clave_profesor'])) {
    // La sesión está iniciada, obtener la clave del profesor
    $clave_profesor = $_SESSION['clave_profesor'];

    // Incluir la conexión a la base de datos
    include('conexion.php');

    // Consultar los comentarios realizados por los alumnos al profesor
    $sql = "SELECT * FROM comentarios_profesor_alumno WHERE clave_profesor = '$clave_profesor'";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios de Alumnos</title>
</head>
<body>
    <h1>Comentarios de Alumnos</h1>
    <table>
        <tr>
            <th>Matrícula del Alumno</th>
            <th>Comentario</th>
        </tr>
        <?php
        // Verificar si hay comentarios para mostrar
        if ($result->num_rows > 0) {
            // Iterar sobre los comentarios y mostrarlos en la tabla
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['matricula'] . "</td>";
                echo "<td>" . $row['comentario'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No hay comentarios disponibles.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
    // Liberar el resultado y cerrar la conexión a la base de datos
    $result->free();
    $conn->close();
} else {
    // Redireccionar al formulario de inicio de sesión si no hay sesión iniciada
    header('Location: login.php');
    exit;
}
?>
