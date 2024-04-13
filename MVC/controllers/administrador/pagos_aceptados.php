<?php
include "conexion.php";

// Consulta SQL para obtener los datos que deseas mostrar
$sql = "SELECT p.folio_pago, p.folio_estudiante, p.verificacion, f.folios_banco, f.fecha_pago 
        FROM pagos_aceptados p 
        INNER JOIN folios_banco f ON p.folio_pago = f.folios_banco";

$result = $conexion->query($sql);

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="aceptadopago.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>Validación de Pagos</title>
</head>
<header class="site-header">
    <div id="desk">
        <div class="site-identity"></div>
        <nav>          
            <ul>
                <li><button class="button" onclick="window.location.href='admin.html'">Inicio</button></li>
                <li><button class="button" onclick="window.location.href='documentacion.php'">Documentación</button></li>
                <li><button class="button" onclick="window.location.href='matriculas.php'">Matrículas</button></li>
                <li><button class="button" onclick="window.location.href='nuevo_admin.html'">Registro Administrador</button></li>
            </ul>
        </nav>
    </div>
</header>

<body>
    <table class="center">
        <thead>
            <tr>
                <th>folio pago</th>
                <th>folio estudiante</th>
                <th>folio banco</th>
                <th>verificacion</th>
                <th>fecha pago</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mostrar los datos en la tabla
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr align='center'>";
                    echo "<td>" . $row["folio_pago"] . "</td>";
                    echo "<td>" . $row["folio_estudiante"] . "</td>";
                    echo "<td>" . $row["folios_banco"] . "</td>";
                    echo "<td>" . $row["verificacion"] . "</td>";
                    echo "<td>" . $row["fecha_pago"] . "</td>";
                    echo "</tr>";
                    
                    echo "<tr>";
                    echo "<td colspan='6'>";
                    echo "<form action='matriculas_nuevas.php' method='post'>";
                    echo "<input type='hidden' name='folio_pago' value='" . $row["folio_pago"] . "'>";
                    echo "<input type='hidden' name='folio_estudiante' value='" . $row["folio_estudiante"] . "'>";
                    echo "<input type='hidden' name='folio_banco' value='" . $row["folios_banco"] . "'>";
                    echo "<input type='hidden' name='verificacion' value='" . $row["verificacion"] . "'>";
                    echo "<input type='hidden' name='fecha_pago' value='" . $row["fecha_pago"] . "'>";
                    
                    // Agregar condición para desactivar el botón si la verificación es igual a 1
                    if ($row["verificacion"] == 1) {
                        echo "<button type='submit' disabled>Agregar a Matrículas Nuevas</button>";
                    } else {
                        echo "<button type='submit'>Agregar a Matrículas Nuevas</button>";
                    }
                    
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No se encontraron datos.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
