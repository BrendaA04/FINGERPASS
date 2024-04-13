<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener los datos del formulario
  $matricula = $_POST['contrasena'];
  $correo = $_POST['correo'];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "efi100cia2";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Error de conexión a la base de datos: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("SELECT matricula, nombre, apellido1, apellido2, fecha_nacimiento, residencia FROM estudiantes_inscritos WHERE correo = ? AND matricula = ?");
$stmt->bind_param("ss", $correo, $matricula);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['correo'] = $correo;
    $_SESSION['loggedin'] = true;

    $stmt->bind_result($matricula, $nombre, $apellido1, $apellido2, $fecha_nacimiento, $residencia);
    $stmt->fetch();

    $_SESSION['matricula'] = $matricula;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellido1'] = $apellido1;
    $_SESSION['apellido2'] = $apellido2;
    $_SESSION['fecha_nacimiento'] = $fecha_nacimiento;
    $_SESSION['residencia'] = $residencia;

    header('Location: index_padre_de_familia.html');
    exit;
} else {
    $error = "Credenciales inválidas";
}

  $stmt->close();
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylec1.css">
  <title>LOGIN</title>
</head>
<body>
  <div class="Main-container">
    <div class="container-login">
      <div class="wrap-login">
        <div class="site-identity"></div>
        <nav>
          <ul>
            <li><a href="index.html">Inicio</a></li>
          </ul>
        </nav>
        <div class="login-pic">
          <img src="https://oresedo.com/wp-content/uploads/2021/02/28-scaled.jpg" alt="IMG">
        </div>
        <?php if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
  <?php } ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <span class="login-form-title">Login</span>
          <div class="wrap-input">
            <input type="text" class="input" name="correo" placeholder="correo" id="correo" required>
            <span class="focus-input"></span>
            <span class="symbol-input">
              <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
          </div>
          <div class="wrap-input">
            <input type="password" class="input" name="contrasena" id="contrasena" placeholder="Password" required>
            <span class="focus-input"></span>
            <span class="symbol-input">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>
          <div class="login-form-btn-container">
            <button class="login-form-btn" >Login</button>
            
          </div>
          <div class="text-center p-t-1">
            <span class="txt1">Forgot</span>
            <a href="#" class="txt2"> Username / Password ?</a>
          </div>
          <div class="text-center p-t-2">
            <a href="#" class="txt2">Create Your Account <i class="fa fa-long-arrow-right " aria-hidden="true"></i></a>
          </div>
        </form>
      </div>
    </div>
  </div>
  
</body>
</html>