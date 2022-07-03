<?php
//Iniciar Sesion al aplicativo 
/*Conexion a la base de datos */
require 'Database.php';

  $clientes="Cliente";
  $empleados="Empleado";

  //Verifica que los campos de email y contraseña esten llenos
  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    //Realiza un select a la tabla de la base de datos
    //Mediante el objeto de conexion. Prepare ejecuta un Query
    //Obtenermos los datos de la tabla, donde el email sea igual al parametro email que aun no lo he definido
    $records = $conn->prepare("SELECT id_usuario, email, password, categoria FROM users WHERE email = :email");
    //Vinculamos el parametro email, lo que obtenemos del metodo post del fomrulario
    $records->bindParam(':email', $_POST['email']);
    //Ejecutamos la Consulta
    $records->execute();
    //Obtener los datos, con una variable, y de esta sonsulta su metodo fetch. Un array asociativo. 
    $results = $records->fetch(PDO::FETCH_ASSOC);
    
    $message = '';
    //Validar que los datos que estamos obteniendo no sea vacia
    $numRegistros = $records->rowCount();
    if ($numRegistros > 0){ 
      //Vamos a verificar las contraseñas las contraseñas del navegador y del resultado del password de la bd
      if(password_verify($_POST['password'], $results['password'])) {
        //Lo asignamos en memoria, ejecutar y almacenar un dato. El Id del usuario. 
        $_SESSION['user_id'] = $results['id_usuario'];
          //Si emepleado es igual a la categoria de la bd
          if($empleados==$results['categoria']){
            //Es un empleado manda a la pantalla Admin
            header("Location: Admin.php?categoria=".$results['categoria']);
          }else{
            //Es un ciente, mandalo a la pantalla Cliente
            header("Location: Cliente.php");
          }
      }else{
        $message = 'Sus credenciales son incorrectas';
      }
    } else {
      $message = 'Usuario no existe';
    }
    echo $message;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingreso al sistema</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
  </head>
  <body class="hold-transition login-page">
    <div class="modal fade" id="modal-danger">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h4 class="modal-title">WMaster</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="mensaje">
            
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">
              <i class="fas fa-times-circle"></i>
              Cerrar
            </button>          
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->    
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="login-logo">
        <img style="width: 99%;" src="css/logo.png">
      </div>
      <div class="card">        
        <div class="card-body login-card-body">
          <p class="login-box-msg"></p>

          <form action="Login.php" method="post" autocomplete="off">
            <input type="hidden" name="FormID" value="<?php echo $_SESSION['FormID']; ?>" />                        
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Usuario" name="email" id="email" required="requiered">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Password" name="password" id="password" required="requiered">
              <span class="input-group-append">
                <button type="button" class="btn btn-default btn-sm" onclick="verRevisarPassword();">
                  <i class="fas fa-eye-slash" name="iIcono" id="iIcono"></i>
                </button>
              </span>
            </div>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-info btn-block">
                  <i class="fas fa-sign-in-alt"></i>
                  Ingresar
                </button>
              </div>
            </div>  
            <a href="Registro.php" class="text-center">Registrarse como nuevo usuario</a>          
          </form>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.login-box -->    
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <script>
      function verRevisarPassword(){
        var cambio = document.getElementById('Password');
        if(cambio.type == "password"){
          cambio.type = "text";
          $('#iIcono').removeClass('fas fa-eye-slash').addClass('fas fa-eye');
        }else{
          cambio.type = "password";
          $('#iIcono').removeClass('fas fa-eye').addClass('fas fa-eye-slash');
        }
      }
      function VerificarMensajeLogin(mensaje){
        if(mensaje.length > 0){
          $('#modal-danger').modal({backdrop: 'static', keyboard: false});
          $('#mensaje').html(mensaje);
        }
        $('#UserNameEntryField').focus();
      }
    </script>
  </body>
</html>