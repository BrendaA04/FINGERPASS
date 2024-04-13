<?php
session_start();

if (isset($_SESSION['matricula']) && isset($_SESSION['nombre']) && isset($_SESSION['apellido1']) && isset($_SESSION['apellido2'])) {
    $matricula = $_SESSION['matricula'];
    $nombre = $_SESSION['nombre'];
    $apellido1 = $_SESSION['apellido1'];
    $apellido2 = $_SESSION['apellido2'];
    $fechaNacimiento = $_SESSION['fecha_nacimiento'];
    $residencia = isset($_SESSION['residencia']) ? $_SESSION['residencia'] : '';
    $correo = $_SESSION['correo'];
} else {
    // Redireccionar al formulario de inicio de sesión si no hay sesión iniciada
    header('Location: login.html');
    exit;
}

// Verificar si se ha enviado el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los nuevos valores enviados desde el formulario
    $nuevoNombre = $_POST['nombre'];
    $nuevoApellido1 = $_POST['apellido1'];
    $nuevoApellido2 = $_POST['apellido2'];
    $nuevaFechaNacimiento = $_POST['fecha_nacimiento'];
    $nuevoResidencia = $_POST['residencia'];

    // Actualizar los datos en la sesión
    $_SESSION['nombre'] = $nuevoNombre;
    $_SESSION['apellido1'] = $nuevoApellido1;
    $_SESSION['apellido2'] = $nuevoApellido2;
    $_SESSION['fecha_nacimiento'] = $nuevaFechaNacimiento;
    $_SESSION['residencia'] = $nuevoResidencia;

    // Actualizar los datos en la base de datos
    // Aquí debes agregar tu lógica para actualizar los datos en la base de datos
    // Dependiendo de cómo esté configurada tu base de datos, puedes utilizar consultas SQL o un ORM para realizar la actualización

    // Ejemplo de consulta SQL para actualizar los datos en la tabla estudiantes_inscritos
    $servername = "localhost";
    $username = "root";
    $password = "12345";
    $database = "efi100cia2";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar si la conexión fue exitosa
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Consulta SQL para actualizar los datos
    $sql = "UPDATE estudiantes_inscritos SET nombre='$nuevoNombre', apellido1='$nuevoApellido1', apellido2='$nuevoApellido2', fecha_nacimiento='$nuevaFechaNacimiento', residencia='$nuevoResidencia' WHERE matricula=$matricula";

    if ($conn->query($sql) === TRUE) {
        // Redireccionar al perfil actualizado
        header('Location: perfil.php');
        exit;
    } else {
        echo "Error al actualizar los datos en la base de datos: " . $conn->error;
    }

    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylei.css">
    <link rel="stylesheet" href="perfil.css">
    <title>Perfil de Estudiante</title>
</head>
<body>
    <header class="site-header">
    <nav>
            <ul>
            <li><button class="button" onclick="window.location.href='index_padre_de_familia.html'">Inicio</button></li>
            <li><button class="button" onclick="window.location.href='documentacion.php'">Documentación</button></li>

            </ul>
        </nav>
    </header>
    <div class="content">
        <h1 style="color: white;">Perfil de Estudiante</h1>
        <div id="profile-container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div>
                    <label for="matricula" style="color: white;">Matrícula:</label>
                    <span><?php echo $matricula; ?></span>
                </div>
                <div>
                    <label for="nombre" style="color: white;">Nombre:</label>
                    <input type="text" name="nombre" value="<?php echo $nombre; ?>" required>
                </div>
                <div>
                    <label for="apellido1" style="color: white;">Apellido Paterno:</label>
                    <input type="text" name="apellido1" value="<?php echo $apellido1; ?>" required>
                </div>
                <div>
                    <label for="apellido2" style="color: white;">Apellido Materno:</label>
                    <input type="text" name="apellido2" value="<?php echo $apellido2; ?>" required>
                </div>
                <div>
                    <label for="fecha_nacimiento" style="color: white;">Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" value="<?php echo $fechaNacimiento; ?>" required>
                </div>
                <div>
                    <label for="residencia" style="color: white;">Municipio de Residencia:</label>
                    <select id="residencia" name="residencia" required>
    <option value="Acatlán"<?php if ($residencia === 'Acatlán') echo ' selected'; ?>>Acatlán</option>
    <option value="Acaxochitlán"<?php if ($residencia === 'Acaxochitlán') echo ' selected'; ?>>Acaxochitlán</option>
    <option value="Actopan"<?php if ($residencia === 'Actopan') echo ' selected'; ?>>Actopan</option>
    <option value="Agua Blanca de Iturbide"<?php if ($residencia === 'Agua Blanca de Iturbide') echo ' selected'; ?>>Agua Blanca de Iturbide</option>
    <option value="Ajacuba"<?php if ($residencia === 'Ajacuba') echo ' selected'; ?>>Ajacuba</option>
    <option value="Alfajayucan"<?php if ($residencia === 'Alfajayucan') echo ' selected'; ?>>Alfajayucan</option>
    <option value="Almoloya"<?php if ($residencia === 'Almoloya') echo ' selected'; ?>>Almoloya</option>
    <option value="Apan"<?php if ($residencia === 'Apan') echo ' selected'; ?>>Apan</option>
    <option value="El Arenal"<?php if ($residencia === 'El Arenal') echo ' selected'; ?>>El Arenal</option>
    <option value="Atitalaquia"<?php if ($residencia === 'Atitalaquia') echo ' selected'; ?>>Atitalaquia</option>
    <option value="Atlapexco"<?php if ($residencia === 'Atlapexco') echo ' selected'; ?>>Atlapexco</option>
    <option value="Atotonilco el Grande"<?php if ($residencia === 'Atotonilco el Grande') echo ' selected'; ?>>Atotonilco el Grande</option>
    <option value="Atotonilco de Tula"<?php if ($residencia === 'Atotonilco de Tula') echo ' selected'; ?>>Atotonilco de Tula</option>
    <option value="Calnali"<?php if ($residencia === 'Calnali') echo ' selected'; ?>>Calnali</option>
    <option value="Cardonal"<?php if ($residencia === 'Cardonal') echo ' selected'; ?>>Cardonal</option>
    <option value="Cuautepec de Hinojosa"<?php if ($residencia === 'Cuautepec de Hinojosa') echo ' selected'; ?>>Cuautepec de Hinojosa</option>
    <option value="Chapantongo"<?php if ($residencia === 'Chapantongo') echo ' selected'; ?>>Chapantongo</option>
    <option value="Chapulhuacán"<?php if ($residencia === 'Chapulhuacán') echo ' selected'; ?>>Chapulhuacán</option>
    <option value="Chilcuautla"<?php if ($residencia === 'Chilcuautla') echo ' selected'; ?>>Chilcuautla</option>
    <option value="Eloxochitlán"<?php if ($residencia === 'Eloxochitlán') echo ' selected'; ?>>Eloxochitlán</option>
    <option value="Emiliano Zapata"<?php if ($residencia === 'Emiliano Zapata') echo ' selected'; ?>>Emiliano Zapata</option>
    <option value="Epazoyucan"<?php if ($residencia === 'Epazoyucan') echo ' selected'; ?>>Epazoyucan</option>
    <option value="Francisco I. Madero"<?php if ($residencia === 'Francisco I. Madero') echo ' selected'; ?>>Francisco I. Madero</option>
    <option value="Huasca de Ocampo"<?php if ($residencia === 'Huasca de Ocampo') echo ' selected'; ?>>Huasca de Ocampo</option>
    <option value="Huautla"<?php if ($residencia === 'Huautla') echo ' selected'; ?>>Huautla</option>
    <option value="Huazalingo"<?php if ($residencia === 'Huazalingo') echo ' selected'; ?>>Huazalingo</option>
    <option value="Huehuetla"<?php if ($residencia === 'Huehuetla') echo ' selected'; ?>>Huehuetla</option>
    <option value="Huejutla de Reyes"<?php if ($residencia === 'Huejutla de Reyes') echo ' selected'; ?>>Huejutla de Reyes</option>
    <option value="Huichapan"<?php if ($residencia === 'Huichapan') echo ' selected'; ?>>Huichapan</option>
    <option value="Ixmiquilpan"<?php if ($residencia === 'Ixmiquilpan') echo ' selected'; ?>>Ixmiquilpan</option>
    <option value="Jacala de Ledezma"<?php if ($residencia === 'Jacala de Ledezma') echo ' selected'; ?>>Jacala de Ledezma</option>
    <option value="Jaltocán"<?php if ($residencia === 'Jaltocán') echo ' selected'; ?>>Jaltocán</option>
    <option value="Juárez Hidalgo"<?php if ($residencia === 'Juárez Hidalgo') echo ' selected'; ?>>Juárez Hidalgo</option>
    <option value="Lolotla"<?php if ($residencia === 'Lolotla') echo ' selected'; ?>>Lolotla</option>
    <option value="Metepec"<?php if ($residencia === 'Metepec') echo ' selected'; ?>>Metepec</option>
    <option value="San Agustín Metzquititlán"<?php if ($residencia === 'San Agustín Metzquititlán') echo ' selected'; ?>>San Agustín Metzquititlán</option>
    <option value="Metztitlán"<?php if ($residencia === 'Metztitlán') echo ' selected'; ?>>Metztitlán</option>
    <option value="Mineral del Chico"<?php if ($residencia === 'Mineral del Chico') echo ' selected'; ?>>Mineral del Chico</option>
    <option value="Mineral del Monte"<?php if ($residencia === 'Mineral del Monte') echo ' selected'; ?>>Mineral del Monte</option>
    <option value="La Misión"<?php if ($residencia === 'La Misión') echo ' selected'; ?>>La Misión</option>
    <option value="Mixquiahuala de Juárez"<?php if ($residencia === 'Mixquiahuala de Juárez') echo ' selected'; ?>>Mixquiahuala de Juárez</option>
    <option value="Molango de Escamilla"<?php if ($residencia === 'Molango de Escamilla') echo ' selected'; ?>>Molango de Escamilla</option>
    <option value="Nicolás Flores"<?php if ($residencia === 'Nicolás Flores') echo ' selected'; ?>>Nicolás Flores</option>
    <option value="Nopala de Villagrán"<?php if ($residencia === 'Nopala de Villagrán') echo ' selected'; ?>>Nopala de Villagrán</option>
    <option value="Omitlán de Juárez"<?php if ($residencia === 'Omitlán de Juárez') echo ' selected'; ?>>Omitlán de Juárez</option>
    <option value="San Felipe Orizatlán"<?php if ($residencia === 'San Felipe Orizatlán') echo ' selected'; ?>>San Felipe Orizatlán</option>
    <option value="Pacula"<?php if ($residencia === 'Pacula') echo ' selected'; ?>>Pacula</option>
    <option value="Pachuca de Soto"<?php if ($residencia === 'Pachuca de Soto') echo ' selected'; ?>>Pachuca de Soto</option>
    <option value="Pisaflores"<?php if ($residencia === 'Pisaflores') echo ' selected'; ?>>Pisaflores</option>
    <option value="Progreso de Obregón"<?php if ($residencia === 'Progreso de Obregón') echo ' selected'; ?>>Progreso de Obregón</option>
    <option value="Mineral de la Reforma"<?php if ($residencia === 'Mineral de la Reforma') echo ' selected'; ?>>Mineral de la Reforma</option>
    <option value="San Agustín Tlaxiaca"<?php if ($residencia === 'San Agustín Tlaxiaca') echo ' selected'; ?>>San Agustín Tlaxiaca</option>
    <option value="San Bartolo Tutotepec"<?php if ($residencia === 'San Bartolo Tutotepec') echo ' selected'; ?>>San Bartolo Tutotepec</option>
    <option value="San Salvador"<?php if ($residencia === 'San Salvador') echo ' selected'; ?>>San Salvador</option>
    <option value="Santiago de Anaya"<?php if ($residencia === 'Santiago de Anaya') echo ' selected'; ?>>Santiago de Anaya</option>
    <option value="Santiago Tulantepec de Lugo Guerrero"<?php if ($residencia === 'Santiago Tulantepec de Lugo Guerrero') echo ' selected'; ?>>Santiago Tulantepec de Lugo Guerrero</option>
    <option value="Singuilucan"<?php if ($residencia === 'Singuilucan') echo ' selected'; ?>>Singuilucan</option>
    <option value="Tasquillo"<?php if ($residencia === 'Tasquillo') echo ' selected'; ?>>Tasquillo</option>
    <option value="Tecozautla"<?php if ($residencia === 'Tecozautla') echo ' selected'; ?>>Tecozautla</option>
    <option value="Tenango de Doria"<?php if ($residencia === 'Tenango de Doria') echo ' selected'; ?>>Tenango de Doria</option>
    <option value="Tepeapulco"<?php if ($residencia === 'Tepeapulco') echo ' selected'; ?>>Tepeapulco</option>
    <option value="Tepehuacán de Guerrero"<?php if ($residencia === 'Tepehuacán de Guerrero') echo ' selected'; ?>>Tepehuacán de Guerrero</option>
    <option value="Tepeji del Río de Ocampo"<?php if ($residencia === 'Tepeji del Río de Ocampo') echo ' selected'; ?>>Tepeji del Río de Ocampo</option>
    <option value="Tepetitlán"<?php if ($residencia === 'Tepetitlán') echo ' selected'; ?>>Tepetitlán</option>
    <option value="Tetepango"<?php if ($residencia === 'Tetepango') echo ' selected'; ?>>Tetepango</option>
    <option value="Villa de Tezontepec"<?php if ($residencia === 'Villa de Tezontepec') echo ' selected'; ?>>Villa de Tezontepec</option>
    <option value="Tezontepec de Aldama"<?php if ($residencia === 'Tezontepec de Aldama') echo ' selected'; ?>>Tezontepec de Aldama</option>
    <option value="Tianguistengo"<?php if ($residencia === 'Tianguistengo') echo ' selected'; ?>>Tianguistengo</option>
    <option value="Tizayuca"<?php if ($residencia === 'Tizayuca') echo ' selected'; ?>>Tizayuca</option>
    <option value="Tlahuelilpan"<?php if ($residencia === 'Tlahuelilpan') echo ' selected'; ?>>Tlahuelilpan</option>
    <option value="Tlahuiltepa"<?php if ($residencia === 'Tlahuiltepa') echo ' selected'; ?>>Tlahuiltepa</option>
    <option value="Tlanalapa"<?php if ($residencia === 'Tlanalapa') echo ' selected'; ?>>Tlanalapa</option>
    <option value="Tlanchinol"<?php if ($residencia === 'Tlanchinol') echo ' selected'; ?>>Tlanchinol</option>
    <option value="Tlaxcoapan"<?php if ($residencia === 'Tlaxcoapan') echo ' selected'; ?>>Tlaxcoapan</option>
    <option value="Tolcayuca"<?php if ($residencia === 'Tolcayuca') echo ' selected'; ?>>Tolcayuca</option>
    <option value="Tula de Allende"<?php if ($residencia === 'Tula de Allende') echo ' selected'; ?>>Tula de Allende</option>
    <option value="Tulancingo de Bravo"<?php if ($residencia === 'Tulancingo de Bravo') echo ' selected'; ?>>Tulancingo de Bravo</option>
    <option value="Xochiatipan"<?php if ($residencia === 'Xochiatipan') echo ' selected'; ?>>Xochiatipan</option>
    <option value="Xochicoatlán"<?php if ($residencia === 'Xochicoatlán') echo ' selected'; ?>>Xochicoatlán</option>
    <option value="Yahualica"<?php if ($residencia === 'Yahualica') echo ' selected'; ?>>Yahualica</option>
    <option value="Zacualtipán de Ángeles"<?php if ($residencia === 'Zacualtipán de Ángeles') echo ' selected'; ?>>Zacualtipán de Ángeles</option>
    <option value="Zapotlán de Juárez"<?php if ($residencia === 'Zapotlán de Juárez') echo ' selected'; ?>>Zapotlán de Juárez</option>
    <option value="Zempoala"<?php if ($residencia === 'Zempoala') echo ' selected'; ?>>Zempoala</option>
    <option value="Zimapán"<?php if ($residencia === 'Zimapán') echo ' selected'; ?>>Zimapán</option>
</select>

                </div>
                <button type="submit" style="color: white;">Guardar</button>
            </form>
            <div>
                <label for="correo" style="color: white;">Correo:</label>
                <span><?php echo $correo; ?></span>
            </div>
        </div>
    </div>
</body>
</html>
