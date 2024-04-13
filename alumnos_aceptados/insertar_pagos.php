<?php
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $folio_estudiante = $_POST['folio_estudiante'];
  $folio_pago = $folio_estudiante . '3314'; // Ejemplo de generación de folio de pago
  $folio_banco = $folio_estudiante . '3314'; // Concatenar el folio del estudiante con '3314'
  
  $sql=  "INSERT INTO pagos_aceptados ( `folio_pago`, `folio_estudiante`, `folio_banco`, `verificacion`) VALUES ( '$folio_pago', '$folio_estudiante', '$folio_banco', '0')";

  if ($conexion->query($sql) === false) {
    // Si la inserción es exitosa, puedes redirigir a una página de confirmación
    header("Location: confirmacion_pago.html");
    exit();
  } else {
    echo "Error al insertar datos: " . $conexion->error;
  }

  $conexion->close();
}
?>
