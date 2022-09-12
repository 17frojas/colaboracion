<?php
require "conexion.php";
require "validations.php";

session_start();
$error=" ";

if ($_POST){
    $user=$_POST['username'];
    $password=$_POST['password'];

    if(camposVaciosLogin($user,$password)){
        $error= " Por favor complete los campos vacíos \n";
    }

    else if(!usuarioExiste($user)){
      $error= "Este usuario $user NO está registrado";
    }

    $sql ="SELECT * FROM administrador WHERE username='$user'";
    $resultado =$mysqli->query($sql);
    $num=$resultado->num_rows;    
    if ($num>0) {
        $row=$resultado->fetch_assoc();
        $pass=$row['password'];
        $pass_compare= $password;
        
        if ($pass==$pass_compare) {
       		  $_SESSION['id']=$row['id'];
            $_SESSION['username']=$row['username'];
            $_SESSION['password']=$row['password'];
            $_SESSION['tipoUser']=$row['tipoUser'];
            $_SESSION['nombres']=$row['nombres'];
            $_SESSION['apellidos']=$row['apellidos'];
            $_SESSION['correo']=$row['correo'];
            $_SESSION['celular']=$row['celular'];
            
            header ("Location: perfilA.php");
        }else{
              $error= "Por favor digite la contraseña correcta";
        }
    }else{
      $sql ="SELECT * FROM estudiantes WHERE username='$user'";
      $resultado =$mysqli->query($sql);
      $num=$resultado->num_rows;    
      if ($num>0) {
          $row=$resultado->fetch_assoc();
          $pass=$row['password'];
          $pass_compare= $password;
          
          if ($pass==$pass_compare) {
              $_SESSION['id']=$row['id'];
              $_SESSION['username']=$row['username'];
              $_SESSION['tipoUser']=$row['tipoUser'];
              header ("Location: visualizarTesisE.php");
        }else{
              $error= "Por favor digite la contraseña correcta";
        }
      }else{
        $sql ="SELECT * FROM docentes WHERE username='$user'";
        $resultado =$mysqli->query($sql);
        $num=$resultado->num_rows;    
        if ($num>0) {
            $row=$resultado->fetch_assoc();
            $pass=$row['password'];
            $pass_compare= $password;
            
            if ($pass==$pass_compare) {
                $_SESSION['id']=$row['id'];
                $_SESSION['username']=$row['username'];
                $_SESSION['tipoUser']=$row['tipoUser'];
                header ("Location: visualizarTesisD.php");
            }else{
                  $error= "Por favor digite la contraseña correcta";
            }
        }else {
          echo "ERR";
        }
      }
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- GOOGLE FONTS 
  <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">-->
  <!-- BOOTSTRAP 4 -->
  <link rel="stylesheet" href="css/bootstrap4.css">
  <!-- FONT AWESOME 5 -->
  <link rel="stylesheet" href="css/font-awesome.css">
  <!-- STYLES -->
  <link rel="stylesheet" href="css/styles.css">
</head>

<body class="udenar">

  <div class="container p-4">
    <div class="row">

      <div class="col-md-4 mx-auto">
        <div class="card text-center">
          <div class="card-header">
            <h3>SignIn</h3>
          </div>
          <img src="img/logo.png" alt="UDENAR" class="card-img-top mx-auto m-2 rounded-circle w-50">
          <div class="card-body">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
              <div class="form-group">
                <input type="text" name="username" placeholder="Nombre de Usuario" class="form-control" autofocus>
              </div>
              <div class="form-group">
                <input type="password" name="password" placeholder="Contraseña" class="form-control">
              </div>
              <button class="btn btn-primary btn-block">
                SignIn
              </button>
            </form>
            <hr>
            <div class="form-group">
              <a class="btn btn-success btn-block" href="registrar.php">Registrarse</a>
            </div>
          </div>
          <div class="text-center">
            <p class="alert-danger">
              <?php echo $error; ?>
            </p>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- SCRIPTS 
  <script src="./public/scripts/jquery-3.3.1.slim.min.js"></script>
  <script src="./public/scripts/popper.min.js"></script>
  <script src="./public/scripts/bootstrap.min.js"></script>-->
</body>

</html>