<?php
include "conexion.php";

// Obtener los datos del formulario enviado
$folio_estudiante = $_POST['folio_estudiante'];
$matricula_nueva = "172211" . $folio_estudiante;
$folio_pago = $_POST["folio_pago"];

// Consulta SQL para insertar el registro en matriculas_nuevas
$sql_insert = "INSERT INTO matriculas_nuevas (matricula, folio_pago)
              VALUES (?, ?)";

// Preparar la consulta
$stmt_insert = $conexion->prepare($sql_insert);

// Asociar los valores de los parámetros
$stmt_insert->bind_param("si", $matricula_nueva, $folio_pago);

if ($stmt_insert->execute()) {
    echo "Registro agregado a Matrículas Nuevas correctamente.";

    // Consulta SQL para obtener los datos del estudiante
    $sql_select = "SELECT nombre, apellido1, apellido2, correo FROM estudiantes_aceptados WHERE folio_estudiante = ?";

    // Preparar la consulta
    $stmt_select = $conexion->prepare($sql_select);

    // Asociar el valor del parámetro
    $stmt_select->bind_param("i", $folio_estudiante);

    // Ejecutar la consulta
    $stmt_select->execute();

    // Obtener el resultado
    $resultado = $stmt_select->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $nombre = $row['nombre'];
        $apellido1 = $row['apellido1'];
        $apellido2 = $row['apellido2'];
        $correo = $row['correo'];

        // Consulta SQL para insertar los datos en la tabla estudiantes_inscritos
        $sql_insert_estudiantes = "INSERT INTO estudiantes_inscritos (matricula, nombre, apellido1, apellido2, fecha_nacimiento, residencia, correo,id_grupo) 
                                   VALUES (?, ?, ?, ?, null, null, ?,1)";

        // Preparar la consulta
        $stmt_insert_estudiantes = $conexion->prepare($sql_insert_estudiantes);

        // Asociar los valores de los parámetros
        $stmt_insert_estudiantes->bind_param("sssss", $matricula_nueva, $nombre, $apellido1, $apellido2, $correo);

        if ($stmt_insert_estudiantes->execute()) {
            echo " Datos insertados correctamente en la tabla estudiantes_inscritos.";

            // Consulta SQL para actualizar el campo verificacion en la tabla pagos_aceptados
            $sql_update = "UPDATE pagos_aceptados SET verificacion = 1 WHERE folio_pago = ?";

            // Preparar la consulta
            $stmt_update = $conexion->prepare($sql_update);

            // Asociar el valor del parámetro
            $stmt_update->bind_param("i", $folio_pago);

            if ($stmt_update->execute()) {
                echo " Registro actualizado en Pagos Aceptados.";

                // Redireccionar a pagos_aceptados.php después de 2 segundos
               header("refresh:2;url=pagos_aceptados.php");
            } else {
                echo "Error al actualizar el registro en Pagos Aceptados: " . $conexion->error;
            }
        } else {
            echo "Error al insertar datos en la tabla estudiantes_inscritos: " . $conexion->error;
        }
    } else {
        echo "No se encontraron datos asociados al folio_estudiante proporcionado.";
    }
} else {
    echo "Error al agregar el registro a Matrículas Nuevas: " . $conexion->error;
}



// Cerrar las consultas preparadas
$stmt_insert->close();
$stmt_select->close();
$stmt_insert_estudiantes->close();
$stmt_update->close();

// Cerrar la conexión
$conexion->close();
?>
