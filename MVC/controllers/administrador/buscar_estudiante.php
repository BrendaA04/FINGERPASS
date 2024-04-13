<!DOCTYPE html>
<html>
<head>
    <title>Resultado de Búsqueda</title>
</head>
<body>
    <h1>Resultado de Búsqueda</h1>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener el valor de matrícula ingresado en el formulario
            $matricula_buscada = $_POST["matricula"];

            // Conexión a la base de datos (sustituye con tus datos)
            include "conexion.php";

            // Consulta para buscar el estudiante por matrícula (búsqueda parcial)
            $sql = "SELECT matricula, nombre, apellido1, apellido2, fecha_nacimiento, residencia, correo FROM estudiantes_inscritos WHERE matricula LIKE '%$matricula_buscada%'";
            $result = $conexion->query($sql);

            // Mostrar resultado de búsqueda
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Matrícula</th><th>Nombre</th><th>Apellido 1</th><th>Apellido 2</th><th>Fecha de Nacimiento</th><th>Residencia</th><th>Correo</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["matricula"] . "</td>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . $row["apellido1"] . "</td>";
                    echo "<td>" . $row["apellido2"] . "</td>";
                    echo "<td>" . $row["fecha_nacimiento"] . "</td>";
                    echo "<td>" . $row["residencia"] . "</td>";
                    echo "<td>" . $row["correo"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontró ningún estudiante con la matrícula proporcionada.";
            }

            $conexion->close();
        }
    ?>
    <br>
    <a href="matriculas.php">Volver a la lista de estudiantes</a>
</body>
</html>
