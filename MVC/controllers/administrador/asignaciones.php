<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/administrador/matriestilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Asignaturas</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body style="background-color: #182f53;">
<header class="site-header">
    <div id="desk">
        <div class="site-identity"></div>
        <nav>
            <ul>
                <li><button class="button" onclick="window.location.href='../../views/administrador/admin.html'">Inicio</button></li>
                <li><button class="button" onclick="window.location.href='documentacion.php'">Documentación</button></li>
                <li><button class="button" onclick="window.location.href='nueva_materia.html'">Registrar asignatura</button></li>
                <li><button class="button" onclick="window.location.href='nueva_asignacion.html'">Registrar Asignacion</button></li>
                <li><button class="button" onclick="window.location.href='asignaciones.php'">Asignaciones</button></li>
                <li><button class="button" onclick="window.location.href='matriculas.php'">Matrículas</button></li>
                <li><button class="button" onclick="window.location.href='logout.php'">Salir</button></li>
            </ul>
        </nav>
    </div>
</header>   

<div class="container">
    <!-- Tabla de asignaturas inscritas -->
    <table class="table table-striped" bgcolor="3FABAF";>
        <tr>
            <th style="color: black;">Asignatura</th>
            <th style="color: black;">Profesor</th>
            <th style="color: black;">Grupo</th>
        </tr>

        <?php
        // Conexión a la base de datos (sustituye con tus datos)
        include "conexion.php";

        $sql = "SELECT asignaturas.Nombre AS NombreAsignatura, CONCAT(profesores.Nombre, ' ', profesores.Ap_paterno, ' ', profesores.Ap_materno) AS NombreProfesor, grupos.Nombre AS NombreGrupo
                FROM asignacionmaterias
                INNER JOIN asignaturas ON asignacionmaterias.id_asignatura = asignaturas.id_asignatura
                INNER JOIN profesores ON asignacionmaterias.clave_profesor = profesores.clave_profesor
                INNER JOIN grupos ON asignacionmaterias.id_grupo = grupos.id_grupo";

        $result = $conexion->query($sql);

        // Mostrar datos en la tabla
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["NombreAsignatura"] . "</td>";
                echo "<td>" . $row["NombreProfesor"] . "</td>";
                echo "<td>" . $row["NombreGrupo"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No se encontraron asignaciones.</td></tr>";
        }

        $conexion->close();
        ?>
    </table>
</div>

</body>
</html>
