<?php
  require 'database.php';
  //Verifica que no esten vacios los campos
  $categorias="Empleado";
  $message = '';
  if (!empty($_POST['nombre'])&&!empty($_POST['email']) && !empty($_POST['password'])){
    //Agregarlos a la base de datos
    
    $sql = "INSERT INTO users (id_usuario,  nombre, email, password, categoria) VALUES (:email, :nombre, :email, :password,:categoria)";
    $db = $conn->prepare($sql);
    $db->bindParam(':nombre', $_POST['nombre']);
    $db->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $db->bindParam(':password', $password);
    $db->bindParam(':categoria', $categorias);
    
    if ($db->execute()) {
      $message = 'Empleado Creado Exitosamente';
    } else {
      $message = 'Error, el usuario ya existe';
    }
    echo $message;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">


<div class="register-box">
  <div class="register-logo">
    <img style="width: 99%;" src="css/logo.png">
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Registro de nuevo empleado</p>

      <form action="RegistroEmpleados.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nombre Completo" name="nombre" id="nombre" required="requiered">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" id="email" required="requiered">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" id="password" required="requiered">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" name="repassword" id="repassword" required="requiered">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               Estoy de acuerdo a los <a href="#">terminos</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <br>
      <a href="Admin.php" class="text-center">Regresar</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>