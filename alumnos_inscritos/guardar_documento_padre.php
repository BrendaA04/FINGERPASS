<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "efi100cia2";

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores enviados del formulario
    $matricula = $_POST['matricula'];
    $tipodocumento = $_POST['tipo_documento'];
    $archivodocumento = $_FILES['archivo_documento'];
    $fechaSubida = $_POST['fecha_subida'];

    // Conectar a la base de datos
    $conexion = new mysqli($servername, $username, $password, $dbname);

    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Verificar si el matricula existe en la base de datos
    $consulta_verificar = "SELECT * FROM estudiantes_inscritos WHERE matricula = '$matricula'";
    $resultado = $conexion->query($consulta_verificar);
    if ($resultado->num_rows === 0) {
        echo '<script> alert("Folio inválido. No se puede guardar el documento.")</script>';
        echo'<script>window.location.href="documentacion.php";</script>';

        exit;
    }

    // Obtener la carpeta correspondiente al tipo de documento
    $carpetaTipoDocumento = '../documentacion/documentos/';
    switch ($tipodocumento) {
        case 'acta':
            $carpetaTipoDocumento .= 'acta/';
            break;
        case 'curp':
            $carpetaTipoDocumento .= 'curp/';
            break;
        case 'ine':
            $carpetaTipoDocumento .= 'ine/';
            break;
        case 'domicilio':
            $carpetaTipoDocumento .= 'domicilio/';
            break;
        case 'primaria':
            $carpetaTipoDocumento .= 'primaria/';
            break;
        case 'medico':
            $carpetaTipoDocumento .= 'medico/';
            break;
        default:
            echo '<script>alert("Tipo de documento inválido.")</script>';
            echo'<script>window.location.href="documentacion.php";</script>';

            exit;
    }

    
    if (!file_exists($carpetaTipoDocumento)) {
        mkdir($carpetaTipoDocumento, 0777, true);
    }

    if (!empty($archivodocumento['name'])) {
        // Verificar si el archivo es un PDF
        $extension = pathinfo($archivodocumento['name'], PATHINFO_EXTENSION);
        if ($extension === 'pdf') {
            $nombreArchivoFinal = $matricula . '_' . $tipodocumento . '.pdf';
            $rutaArchivoFinal = $carpetaTipoDocumento . $nombreArchivoFinal;

            $consulta_existente = "SELECT * FROM documentos_ingreso WHERE matricula = '$matricula' AND tipo_documento = '$tipodocumento' AND documento = '$nombreArchivoFinal'";
            $resultado_existente = $conexion->query($consulta_existente);
            if ($resultado_existente->num_rows > 0) {
                echo '<script>alert("Ya se ha subido el mismo documento PDF.")</script>';
                echo'<script>window.location.href="documentacion.php";</script>';
                exit;
            }

            // Mover el archivo a la carpeta correspondiente y renombrarlo
            if (move_uploaded_file($archivodocumento['tmp_name'], $rutaArchivoFinal)) {
                // El archivo se ha guardado correctamente en la carpeta correspondiente
                echo '<script>alert("El archivo se ha guardado correctamente en la carpeta $carpetaTipoDocumento.")</script>';
                echo'<script>window.location.href="documentacion.php";</script>';

                // Guardar el nombre del archivo en la base de datos
                $consulta_insertar = " INSERT INTO `documentos_ingreso`(`id_documento`, `matricula`, `tipo_documento`, `documento`, `fecha_subida`, `verificacion`, `comentarios`) VALUES (NULL, '$matricula', '$tipodocumento', '$nombreArchivoFinal', '$fechaSubida','0','pendiente');";
                if ($conexion->query($consulta_insertar) === TRUE) {
                    echo '<script>alert("Los datos se han guardado correctamente en la base de datos.")</script>';
                    echo'<script>window.location.href="documentacion.php";</script>';

                } else {
                    echo "Error al guardar los datos en la base de datos: " . $conexion->error;
                }
            } else {
                // Error al mover el archivo
                echo '<script>alert("Error al mover el archivo.")</script>';
                echo'<script>window.location.href="documentacion.php";</script>';

            }
        } else {
            // El archivo no es un PDF
            echo '<script>alert("El archivo debe ser un PDF.")</script>';
            echo'<script>window.location.href="documentacion.php";</script>';

        }
    } else {
        // No se ha seleccionado ningún archivo
        echo "No se ha seleccionado ningún archivo.";
    }

    // Verificar si se han subido los documentos requeridos
    $documentosRequeridos = ['ACTA', 'CURP', 'INE', 'DOMICILIO','MEDICO','PRIMARIA'];
    $consulta_documentos = "SELECT COUNT(*) AS count FROM documentos_ingreso WHERE matricula = '$matricula' AND tipo_documento IN ('acta', 'CURP', 'INE', 'domicilio')";
    $resultado_documentos = $conexion->query($consulta_documentos);
    $fila_documentos = $resultado_documentos->fetch_assoc();
    $cantidadDocumentos = $fila_documentos['count'];

    if ($cantidadDocumentos >= count($documentosRequeridos)) { 
        
        echo '<script>alert("Se han subido todos los documentos requeridos.")</script>';
        echo'<script>window.location.href="index_padre_de_familia.php";</script>';

        exit;
    } else {
        echo '<script>("Faltan documentos requeridos.")</script>';
        
        echo'<script>window.location.href="documentacion.php";</script>';

        exit;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
}
?>
