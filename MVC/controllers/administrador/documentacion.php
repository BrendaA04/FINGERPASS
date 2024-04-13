<?php
// Verificar si se envió una búsqueda
if (isset($_GET['buscar'])) {
    $busqueda_folio = $_GET['matricula'];
} else {
    $busqueda_folio = '';
}

// Conexión a la base de datos
include "conexion.php";

// Consulta para buscar documentos por Folio del Estudiante
$consulta = "SELECT * FROM documentos_ingreso WHERE matricula LIKE '%$busqueda_folio%'";
$resultado = mysqli_query($conexion, $consulta);

// Función para obtener la clase de color según el valor de verificación
function getColorClass($verificacion) {
    if ($verificacion == 0) {
        return "bg-warning"; // Amarillo
    } elseif ($verificacion == 1) {
        return "bg-success"; // Verde
    } elseif ($verificacion == 2) {
        return "bg-danger"; // Rojo
    } else {
        return ""; // Sin color
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/administrador/documentacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>Documentacion Del Estudiante</title>

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
                <li><button class="button" onclick="window.location.href='../../controllers/administrador/matriculas.php'">Matrículas</button></li>
                <li><button class="button" onclick="window.location.href='../../controllers/administrador/logout.php'">Salir</button></li>
            </ul>

            </nav>
        </div>
    </header> 
</body>
<body>
    <br>
    <div class="container">
        <div class="col-sm-12">
            <h2  style="text-align: center; color: white;" >Validacion de documentacion</h2>
            <br>
            <br>

            <!-- Formulario de búsqueda -->
            <form action="documentacion.php" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="matricula" class="form-control"
                        placeholder="Buscar por Folio del Estudiante" value="<?php echo $busqueda_folio; ?>">
                    <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                </div>
            </form>

            <?php
          
          // Mostrar los resultados en la tabla o el mensaje de alerta
          if (mysqli_num_rows($resultado) > 0) {
              echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">';
              echo '<thead>';
              echo '<tr>';
              echo '<th>matricula</th>';
              echo '<th>Tipo de Documento</th>';
              echo '<th>Documento</th>';
              echo '<th>Comentarios</th>';
              echo '<th>Fecha de Subida</th>';
              echo '<th>Descargar</th>';
              echo '<th>Acciones</th>';
              echo '</tr>';
              echo '</thead>';
              echo '<tbody>';

              while ($fila = mysqli_fetch_assoc($resultado)) {
                  // Obtener la clase de color según el valor de verificación
                  $colorClass = getColorClass($fila['verificacion']);

                  echo '<tr class="' . $colorClass . '">';
                  echo '<td>' . $fila['matricula'] . '</td>';
                  echo '<td>' . $fila['tipo_documento'] . '</td>';
                  echo '<td>' . $fila['documento'] . '</td>';
                  echo '<td>' . $fila['comentarios'] . '</td>';
                  echo '<td>' . $fila['fecha_subida'] . '</td>';
                  echo '<td><a href="descargar.php?id_documento=' . $fila['id_documento'] . '">Descargar</a></td>';
                  echo '<td>';
                   // Botón de la listo para cambiar a verificación 1
            echo '<form action="actualizar_documento.php" method="post" style="display: inline-block;">';
            echo '<input type="hidden" name="id_documento" value="' . $fila['id_documento'] . '">';
            echo '<button type="submit" name="verificacion" value="1" class="btn btn-success">listo</button>';
            echo '</form>';

            // Botón de la "x"  para abrir la ventana emergente de comentarios
            echo '<button class="btn btn-danger" onclick="openComentarios(' . $fila['id_documento'] . ')">X </button>';

                  echo '</td>';
                  echo '</tr>';
              }

              echo '</tbody>';
              echo '</table>';
          } else {
              // Mostrar mensaje de alerta cuando no se encuentran resultados
              if (isset($_GET['buscar'])) {
                  echo '<h2>No se encontraron resultados.</h2>';
                  echo '<script>alert("No se encontraron resultados.");</script>';
              }
          }

          // Cerrar la conexión a la base de datos
          mysqli_close($conexion);
          ?>
      </div>
  </div>
  <!-- Ventana emergente para agregar comentarios -->
  <div id="comentariosModal" style="display: none;">
            <h3 style="color: white;">Agregar Comentarios</h3>
            <form action="actualizar_documento.php" method="post">
                <input type="hidden" id="comentariosDocumentoId" name="id_documento" value="">
                <textarea name="comentarios" rows="4" cols="50"></textarea>
                <button type="submit" name="verificacion" value="2" class="btn btn-danger">Guardar Comentarios</button>
            </form>
        </div>

        <!-- ... Código HTML posterior ... -->

        <script>
            // Función para abrir la ventana emergente de comentarios
            function openComentarios(id_documento) {
                document.getElementById('comentariosDocumentoId').value = id_documento;
                document.getElementById('comentariosModal').style.display = 'block';
            }
        </script>
</body>
</html>