<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/administrador/matriestilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>profesors</title>

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
            <li><button class="button" onclick="window.location.href='../../views/administrador/nuevo_profesor.html'">Registrar Profesor</button></li>
            <li><button class="button" onclick="window.location.href='logout.php'">Salir</button></li>

            </ul>
        </nav>
    </div>
</header>   
</body>
<body>
    <div class="container">
        <!-- Formulario para búsqueda por matrícula -->
        <form action="#" method="post">
            <label for="clave_profesor" style="color: white;">Buscar por Matrícula:</label>
            <input type="text" name="clave_profesor" id="clave_profesor" required>
            <input type="submit" value="Buscar">
        </form>

        <!-- Tabla de profesoress inscritos -->
        <table class="table table-striped" bgcolor="3FABAF";>
            <tr>
                <th style="color: black;">clave</th>
                <th style="color: black;">Nombre</th>
                <th style="color: black;">Apellido 1</th>
                <th style="color: black;">Apellido 2</th>
                <th style="color: black;">Correo</th>
            </tr>

            <?php
            // Conexión a la base de datos (sustituye con tus datos)
            include "conexion.php";

            // Verificar si se envió una búsqueda
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtener el valor de matrícula ingresado en el formulario
                $clave_profesor_buscada = $_POST["clave_profesor"];

                // Consulta para buscar el profesores por matrícula (búsqueda parcial)
                $sql = "SELECT clave_profesor, nombre, ap_paterno, ap_materno, fecha_nacimiento, residencia, correo FROM profesores WHERE clave_profesor LIKE '%$clave_profesor_buscada%'";
                $result = $conexion->query($sql);

                // Mostrar resultado de búsqueda
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["clave_profesor"] . "</td>";
                        echo "<td>" . $row["nombre"] . "</td>";
                        echo "<td>" . $row["ap_paterno"] . "</td>";
                        echo "<td>" . $row["ap_materno"] . "</td>";
                        echo "<td>" . $row["correo"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No se encontró ningún profesor .</td></tr>";
                }
            } else {
                // Consulta para obtener todos los profesors
                $sql = "SELECT clave_profesor, nombre, ap_paterno, ap_materno, correo FROM profesores";
                $result = $conexion->query($sql);

                // Mostrar datos en la tabla
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["clave_profesor"] . "</td>";
                        echo "<td>" . $row["nombre"] . "</td>";
                        echo "<td>" . $row["ap_paterno"] . "</td>";
                        echo "<td>" . $row["ap_materno"] . "</td>";
                        echo "<td>" . $row["correo"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No se encontraron profesors.</td></tr>";
                }
            }

            $conexion->close();
            ?>
        </table>
    </div>
</body>

</html>
