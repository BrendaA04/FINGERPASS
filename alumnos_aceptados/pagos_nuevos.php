<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acceso para pagar</title>
  <link rel="stylesheet" href="nuevospagos.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

<header class="site-header">
    <nav>
            <ul>
            <li><button class="button" onclick="window.location.href='/efi1002/index.html'">Inicio</button></li>
            </ul>
        </nav>
  </header>
  <table id="miTabla">
    <thead>
        <tr>
        <th>Folio</th>
        <th>Nombre</th>
        <th>Apellido 1</th>
        <th>Apellido 2</th>
        <th>Acciones</th>
      </tr>
    </thead>

    <tbody>
  
    <?php
    
session_start(); // Iniciar la sesión (si no se ha iniciado anteriormente)

// Verificar si las variables de sesión están definidas
if (isset($_SESSION['folio_estudiante']) && isset($_SESSION['nombre']) && isset($_SESSION['apellido1']) && isset($_SESSION['apellido2'])) {
  $folio_estudiante = $_SESSION['folio_estudiante'];
  $nombre = $_SESSION['nombre'];
  $apellido1 = $_SESSION['apellido1'];
  $apellido2 = $_SESSION['apellido2'];

  // Mostrar los datos en filas de la tabla
  echo "<tr>";
  echo "<td>$folio_estudiante</td>";
  echo "<td>$nombre</td>";
  echo "<td>$apellido1</td>";
  echo "<td>$apellido2</td>";
  echo "<td><button onclick='insertarYPagar(\"$folio_estudiante\")'>Ir a pagar</button></td>";
  echo "</tr>";
} else {
  echo "<tr><td colspan='5'>No se encontraron datos de sesión.</td></tr>";
}

?>
      
    </tbody>
  </table>

  <script>
    function insertarYPagar(folio_estudiante) {
      // Realizar una solicitud AJAX para insertar los pagos
      $.ajax({
        url: "insertar_pagos.php",
        method: "POST",
        data: { folio_estudiante: folio_estudiante },
        success: function() {
          // Después de la inserción exitosa, redirigir a confirmacion_pago.html
          window.location.href = "confirmacion_nuevos.html?folio_estudiante=" + folio_estudiante;
        },
        error: function() {
          alert("Error al insertar los pagos.");
        }
      });
    }
  </script>
</body>
</html>
