<?php
// Incluir archivo de conexión a la base de datos
include "conexion.php";

session_start();

// Verificar si los datos de sesión están establecidos
if (!isset($_SESSION['matricula'])) {
    echo "Datos no encontrados";
    header('Location: index_padre_de_familia.html');
    exit;
}

// Obtener la matrícula del estudiante desde la sesión
$matricula = $_SESSION['matricula'];

// Consultar las materias en las que el alumno tiene comentarios
$sql_materias = "SELECT DISTINCT A.id_asignatura, A.nombre AS materia 
                FROM comentarios_profesor_alumno C 
                JOIN asignaturas A ON C.id_asignatura = A.id_asignatura 
                WHERE C.matricula = '$matricula'";
$result_materias = $conexion->query($sql_materias);

// Obtener el grupo del estudiante
$sql_grupo = "SELECT id_grupo FROM estudiantes_inscritos WHERE matricula = '$matricula'";
$result_grupo = $conexion->query($sql_grupo);
$row_grupo = $result_grupo->fetch_assoc();
$id_grupo = $row_grupo['id_grupo'];

// Verificar si se ha enviado el formulario de respuesta
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['respuesta'])) {
    // Obtener los datos del formulario de respuesta
    $respuesta = $_POST['respuesta'];
    $id_grupo = $_POST['id_grupo'];
    $id_asignatura = $_POST['id_asignatura'];
    $comentario = $_POST['comentario'];
    $profesor = $_POST['profesor'];
    $clave_profesor = $_POST['clave_profesor'];

    // Preparar y ejecutar la consulta para insertar la respuesta en la tabla
    $stmt = $conexion->prepare("INSERT INTO respuestas_profesor_alumno (clave_profesor, matricula, id_asignatura, id_grupo, respuesta) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $clave_profesor, $matricula, $id_asignatura, $id_grupo, $respuesta);

    if ($stmt->execute()) {
        echo "Respuesta enviada correctamente";
    } else {
        echo "Error al enviar la respuesta: " . $conexion->error;
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylei.css">
    <link rel="stylesheet" href="perfil.css">
    <title>Documentación de alumno</title>
    <style>
        /* Estilos generales */
        body {
            display: flex;
            flex-direction: column;
            justify-content: top;
            align-items: center;
            min-height: 100vh;
            background: #83B5F1;
            font-family: "Fira Sans", Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Estilos del formulario */
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 20px;
        }
        
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
      
        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: black;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        /* Agrega estilos para las celdas de verificación */
        .verificacion-amarillo {
            background-color: yellow;
        }

        .verificacion-rojo {
            background-color: red;
            color: white; /* Para mejorar la legibilidad del texto en fondo rojo */
        }

        .verificacion-verde {
            background-color: green;
            color: white; /* Para mejorar la legibilidad del texto en fondo verde */
        }
    </style>
</head>
<body>
    <header class="site-header">
        <nav>
            <ul>
                <li><button class="button" onclick="window.location.href='index_padre_de_familia.html'">Inicio</button></li>
                <li><button class="button" onclick="window.location.href='perfil.php'">Perfil</button></li>
            </ul>
        </nav>
    </header>
    <!-- Formulario para seleccionar la materia -->
    <div class="container">
        <h2>Seleccionar Materia:</h2>
        <form action="" method="POST">
            <label for="materia">Materia:</label>
            <select name="materia_seleccionada" id="materia">
                <?php
                // Mostrar las materias disponibles en el menú desplegable
                while ($row_materia = $result_materias->fetch_assoc()) {
                    echo "<option value='" . $row_materia['id_asignatura'] . "'>" . $row_materia['materia'] . "</option>";
                }
                ?>
            </select>
            <button type="submit">Mostrar Comentarios</button>
        </form>
    </div>

    <!-- Tabla para mostrar los comentarios -->
    <div class="container">
        <?php if (isset($_POST['materia_seleccionada'])) { ?>
            <h2>Comentarios del Profesor:</h2>
            <table>
                <tr>
                    <th>Comentario</th>
                    <th>Profesor</th>
                    <th>Responder</th>
                </tr>
                
                <?php
                // Obtener la materia seleccionada
                $materia_seleccionada = $_POST['materia_seleccionada'];
                
                // Consultar los comentarios correspondientes a la matrícula del alumno y la materia seleccionada
                $sql = "SELECT C.comentario, P.nombre AS profesor, P.clave_profesor
                        FROM comentarios_profesor_alumno C 
                        JOIN profesores P ON C.clave_profesor = P.clave_profesor 
                        WHERE C.matricula = '$matricula' AND C.id_asignatura = '$materia_seleccionada'";
                $result = $conexion->query($sql);
                
                // Verificar si hay comentarios para mostrar
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['comentario'] . "</td>";
                        echo "<td>" . $row['profesor'] . "</td>";
                        echo "<td>";
                        echo "<form action='' method='POST'>";
                        echo "<input type='hidden' name='materia_seleccionada' value='$materia_seleccionada'>";
                        echo "<input type='hidden' name='id_asignatura' value='$materia_seleccionada'>"; // Nuevo
                        echo "<input type='hidden' name='id_grupo' value='$id_grupo'>"; // Nuevo
                        echo "<input type='hidden' name='comentario' value='" . $row['comentario'] . "'>";
                        echo "<input type='hidden' name='profesor' value='" . $row['profesor'] . "'>";
                        echo "<input type='hidden' name='clave_profesor' value='" . $row['clave_profesor'] . "'>"; // Nuevo: Añadir la clave del profesor como campo oculto
                        echo "<label for='respuesta'>Respuesta:</label>";
                        echo "<textarea name='respuesta' id='respuesta' cols='30' rows='3' required></textarea><br>";
                        echo "<button type='submit'>Enviar respuesta</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No se encontraron comentarios para esta materia.</td></tr>";
                }
                ?>
            </table>
        <?php } ?>
    </div>
    
    <script src="js/jquery.min.js"></script>
    <script>
        // Aquí va tu código JavaScript existente
    </script>
</body>
</html>
