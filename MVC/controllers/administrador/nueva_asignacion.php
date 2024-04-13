<?php

include 'conexion.php';

// Consulta para obtener las asignaturas
$sql_asignaturas = "SELECT Nombre FROM asignaturas";
$resultado_asignaturas = $conexion->query($sql_asignaturas);

// Consulta para obtener los profesores
$sql_profesores = "SELECT Nombre FROM profesores";
$resultado_profesores = $conexion->query($sql_profesores);

// Consulta para obtener los grupos
$sql_grupos = "SELECT DISTINCT Nombre FROM Grupos";
$resultado_grupos = $conexion->query($sql_grupos);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/administrador/aprueba.css">
    <link rel="stylesheet" href="../../styles/administrador/pagosacep.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Registro de materias</title>
</head>
<body>
    <div class="site-header">
        <div id="desk">
            <div class="site-identity"></div>
            <nav>
                <ul class="button-list">
                    <li><button class="button" onclick="window.location.href='admin.html'">Inicio</button></li>
                    <li><button class="button" onclick="window.location.href='logout.php'">Salir</button></li>
                </ul>
            </nav>
        </div>
    </div>
    <h2 style="color: white;">Formulario de Asignaciones</h2>
    <form action="nueva_asignacion.php" method="post" class="formulario2">
        <label for="asignatura" style="color: white;">Asignatura:</label>
<select id="asignatura" name="asignatura" required>
    <?php while ($fila_asignatura = $resultado_asignaturas->fetch_assoc()): ?>
        <option value="<?php echo $fila_asignatura['Nombre']; ?>"><?php echo $fila_asignatura['Nombre']; ?></option>
    <?php endwhile; ?>
</select><br>

<label for="profesor" style="color: white;">Profesor:</label>
<select id="profesor" name="profesor" required>
    <?php while ($fila_profesor = $resultado_profesores->fetch_assoc()): ?>
        <option value="<?php echo $fila_profesor['Nombre']; ?>"><?php echo $fila_profesor['Nombre']; ?></option>
    <?php endwhile; ?>
</select><br>

<label for="grupo" style="color: white;">Grupo:</label>
<select id="grupo" name="grupo" required>
    <?php while ($fila_grupo = $resultado_grupos->fetch_assoc()): ?>
        <option value="<?php echo $fila_grupo['Nombre']; ?>"><?php echo $fila_grupo['Nombre']; ?></option>
    <?php endwhile; ?>
</select><br>


        <input type="submit" value="Enviar" style="background-color: #3FABAF; color: white;">

    </form>
</body>
</html>

<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asignatura_nombre = $_POST["asignatura"];
    $grupo = $_POST["grupo"];
    $profesor_nombre = $_POST["profesor"];

    // Buscar el ID de la asignatura basado en su nombre
    $stmt_asignatura = $conexion->prepare("SELECT id_asignatura FROM asignaturas WHERE nombre = ?");
    $stmt_asignatura->bind_param("s", $asignatura_nombre);
    $stmt_asignatura->execute();
    $resultado_asignatura = $stmt_asignatura->get_result();
    
    if ($resultado_asignatura->num_rows == 0) {
        die("No se encontró la asignatura con el nombre proporcionado.");
    }
    
    $fila_asignatura = $resultado_asignatura->fetch_assoc();
    $id_asignatura = $fila_asignatura['id_asignatura'];

    // Buscar el ID del profesor basado en su nombre
    $stmt_profesor = $conexion->prepare("SELECT clave_profesor FROM profesores WHERE Nombre = ?");
    $stmt_profesor->bind_param("s", $profesor_nombre);
    $stmt_profesor->execute();
    $resultado_profesor = $stmt_profesor->get_result();
    
    if ($resultado_profesor->num_rows == 0) {
        die("No se encontró al profesor con el nombre proporcionado.");
    }
    
    $fila_profesor = $resultado_profesor->fetch_assoc();
    $id_profesor = $fila_profesor['clave_profesor'];
    $stmt_grupo = $conexion->prepare("SELECT id_grupo FROM grupos WHERE nombre = ?");
    $stmt_grupo->bind_param("s", $grupo);
    $stmt_grupo->execute();
    $resultado_grupo = $stmt_grupo->get_result();
    
    if ($resultado_grupo->num_rows == 0) {
        die("No se encontró el grupo con el nombre proporcionado.");
    }
    
    $fila_grupo = $resultado_grupo->fetch_assoc();
    $id_grupo = $fila_grupo['id_grupo'];

    // Consulta preparada para insertar en la tabla asignacionmaterias
    $stmt = $conexion->prepare("INSERT INTO asignacionmaterias (id_asignacion, id_asignatura, clave_profesor, id_grupo) VALUES (NULL, ?, ?, ?)");
    $stmt->bind_param("iii", $id_asignatura, $id_profesor, $id_grupo);

// Define el valor para id_asignacion (puede ser un valor específico o NULL dependiendo de tu lógica de negocio)
$id_asignacion = 1;

if ($stmt->execute()) {
    echo "Registro exitoso.";
} else {
    // Hubo un error en la inserción
    echo "Error al registrar la asignación de materia: " . $stmt->error;
}

    $stmt->close();
    $conexion->close();
}
?>
