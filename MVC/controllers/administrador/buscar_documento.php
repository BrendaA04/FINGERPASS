<?php
if (isset($_GET['matricula'])) {
    $busqueda_folio = $_GET['matricula'];
} else {
    $busqueda_folio = '';
}

// Conexión a la base de datos
include "conexion.php";

// Consulta para buscar documentos por Folio del Estudiante
$consulta = "SELECT * FROM documentos_ingreso WHERE matricula LIKE '%$busqueda_folio%'";
$resultado = mysqli_query($conexion, $consulta);

// Mostrar los resultados en la tabla o el mensaje de alerta
if (mysqli_num_rows($resultado) > 0) {
    echo '<h2>Resultados de búsqueda:</h2>';
    echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>matricula</th>';
    echo '<th>Tipo de Documento</th>';
    echo '<th>Documento</th>';
    echo '<th>Fecha de Subida</th>';
    echo '<th>Descargar</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo '<tr>';
        echo '<td>' . $fila['matricula'] . '</td>';
        echo '<td>' . $fila['tipo_documento'] . '</td>';
        echo '<td>' . $fila['documento'] . '</td>';
        echo '<td>' . $fila['fecha_subida'] . '</td>';
        echo '<td><a href="descargar.php?id_documento=' . $fila['id_documento'] . '">Descargar</a></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    // Mostrar mensaje de alerta cuando no se encuentran resultados
    echo '<h2>No se encontraron resultados.</h2>';
    echo '<script>alert("No se encontraron resultados.");</script>';
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
