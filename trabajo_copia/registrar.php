<?php
require 'conexion.php';
require 'validations.php';

session_start();
$error = "";
$mensaje = "";

if($_POST){
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $cedula = $_POST['cedula'];
    $celular = $_POST['celular'];
    $codigo = $_POST['codigo'];
    $rol = $_POST['rol'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $programa = "NN";
    $sede = "NN";
    if (isset($_POST['programa'])) {
      $programa = $_POST['programa'];
    }
    if (isset($_POST['sede'])) {
      $sede = $_POST['sede'];
    }
    if($rol==""){
      $error = "Elija el tipo de usuario";
    }
    else{
      if($rol=="Estudiante"){
        if(camposVaciosEst($nombres, $apellidos, $email, $cedula, $codigo, $celular, $rol, $programa, $sede, $username, $password)){
          $error = "$rol Debe llenar todos los campos";
        }else{
          ///Registrar nuevo 
          if(usuarioExiste($username)){
            $error = "El usuario $username ya existe";
          } else {
            $tipoUser = 2;
            
            $sql = "INSERT INTO estudiantes (cedula, username, password, nombres, apellidos, correo, celular, codigo, programa, sede, rol, tipoUser) VALUES ('$cedula','$username','$password','$nombres','$apellidos','$email',   '$celular','$codigo','$programa',  '$sede','ESTUDIANTE',2)";
            $resultado=$mysqli->query($sql);
            if($resultado){
              $mensaje ="Se registró al $rol $nombres $apellidos exitosamente ";
            }
            else{
                $error = "Falló registrar al $rol";
            }
          }
        }
      }
      if($rol=="Docente"){
        if(camposVaciosDoc($nombres, $apellidos, $email, $cedula, $codigo, $celular, $rol, $username, $password)){
                $error = "$rol Debe llenar todos los campos ";
        }else {
                if(usuarioExiste($username)){
                  $error = "El usuario $username ya existe";
                } else {
                  $tipoUser = 3;
                  $sql = "INSERT INTO docentes (cedula, username, password, nombres, apellidos, correo, celular, codigo, rol, tipoUser) VALUES ('$cedula','$username','$password','$nombres','$apellidos','$email',   '$celular','$codigo','DOCENTE',3)";
                  $resultado=$mysqli->query($sql);
                  if($resultado){
                    $mensaje ="Se registró al $rol $nombres $apellidos exitosamente ";
                  }
                  else{
                      $error = "Falló registrar. $rol ";
                  }
                }
        }
      }
      
      
    }
} 
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Notes App</title>
  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
  <!-- BOOTSTRAP 4 -->
  <link rel="stylesheet" href="css/bootstrap4.css">
  <!-- FONT AWESOME 5 -->
  <link rel="stylesheet" href="css/font-awesome.css">
  <!-- STYLES -->
  <link rel="stylesheet" href="css/styles.css">

  <script language="javascript" src="scripts/jquery-3.3.1.slim.min.js"></script>

  <script language="javascript">
    function mostrar(rol) {
      if (rol == "Estudiante") {
        $("#estudiante").show();
        $("#form").show();
      }

      if (rol == "Docente") {
        $("#estudiante").hide();
        $("#form").show();
      }
    }
    $(document).ready(
    );

  </script>

</head>

<body class="udenar">

  <div class="container p-4">


    <div class="card text-center">
      <div class="card-header">
        <h3>Registrarse</h3>
        <div class="col-md-4 mx-auto">
          <img src="img/logo.png" alt="UDENAR" class="card-img-top mx-auto m-6 rounded-circle w-50">
        </div>
        <div class="text-center">
          <p class="alert-danger">
            <?php echo $error; ?>
          </p>
        </div>
        <div class="text-center">
          <p class="alert-primary">
            <?php echo $mensaje; ?>
          </p>
        </div>
      </div>
      <div class="card-body">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
          <div class="form-group">
            <div class="form-group"> Selecciona Tipo de Usuario: <br><select name="rol" id="rol"
                onChange="mostrar(this.value);">
                <option value="">...Tipo de Usuario</option>
                <option value="Estudiante">Estudiante</option>
                <option value="Docente">Docente</option>
              </select>
            </div>
          </div>
          <div id="form" style="display: none;">
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="type" name="nombres" placeholder="Nombres" class="form-control" autofocus>
              </div>
              <div class="col-sm-6">
                <input type="type" name="apellidos" placeholder="Apellidos" class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="number" name="cedula" placeholder="Documento de identidad" class="form-control">
              </div>
              <div class="col-sm-6">
                <input type="number" name="celular" placeholder="Celular" class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="email" name="email" placeholder="Correo Electrónico" class="form-control">

              </div>
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="number" name="codigo" placeholder="Código" class="form-control">

              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" name="username" placeholder="Usuario" class="form-control">
              </div>
              <div class="col-sm-6">
                <input type="password" name="password" placeholder="Contraseña" class="form-control">
              </div>
            </div>
          </div>

          <div id="estudiante" style="display: none;">
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" name="sede" placeholder="Sede" class="form-control">
              </div>
              <div class="col-sm-6">
                <input type="text" name="programa" placeholder="Programa Académico" class="form-control">
              </div>
            </div>
          </div>

          <div class="form-group col-sm-6 mx-auto">
            <button type="submit" class="btn btn-success btn-block ">
              Registrarse
            </button>
          </div>

        </form>

      </div>
      <hr>
      <div class="form-group">
        <div class="col-sm-6 mx-auto">
          <a class="btn btn-primary btn-block" href="login.php">Iniciar Sesión</a>

        </div>
      </div>
    </div>


  </div>

  <!-- SCRIPTS 
  <script src="scripts/jquery-3.3.1.slim.min.js"></script>
  <script src="scripts/popper.min.js"></script>
  <script src="scripts/bootstrap.min.js"></script>-->
</body>

</html>