<?php
require 'conexion.php';
require 'validations.php';
session_start();


if (!isset($_SESSION['id'])) {
    header("Location:login.php");
}
$Id_Usuario = $_GET['id'];
$tipo = $_GET['tipo'];
$Usuario = $_SESSION['username'];
$error="";
$mensaje="";
$rol = 'Estudiante';
$id_Tesis=0;


$sql = "SELECT * FROM estudiantes WHERE id=$Id_Usuario";
$resultado = $mysqli-> query ($sql);
while ($row=$resultado->fetch_assoc() ) {
  $Id = $row['id'];
  $Usuario = $row['username'];
  $id_Tesis=$row['idTesis'];
}

if($_POST){
  $nombres = $_POST['nombres'];
  $apellidos = $_POST['apellidos'];
  $email = $_POST['email'];
  $cedula = $_POST['cedula'];
  $codigo = $_POST['codigo'];
  $celular = $_POST['celular'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $programa = $_POST['programa'];
  $sede = $_POST['sede'];
  
  
  if(camposVaciosEst($nombres, $apellidos, $email, $cedula, $codigo, $celular, $rol, $programa, $sede, $username, $password)){
    $error = "$rol Debe llenar todos los campos";
  }else{
    ///Modificar 
    $sqlMod="UPDATE estudiantes SET username='' WHERE id = $Id_Usuario";
    $resultadoMod = $mysqli-> query ($sqlMod);
                        
    if(usuarioExiste($username)){
      $sqlMod2="UPDATE estudiantes SET username='$Usuario' WHERE id = $Id_Usuario";
      $resultadoMod2 = $mysqli-> query ($sqlMod2);
      $error = "El usuario $username ya existe";
      
    } else {
      $tipoUser = 2;
      $sqlModificar="UPDATE estudiantes SET cedula='$cedula',codigo='$codigo', username='$username', password='$password', nombres='$nombres', apellidos='$apellidos', correo='$email', celular='$celular', programa='$programa', sede='$sede' WHERE id = $Id_Usuario";
      $resultadoModificar = $mysqli-> query ($sqlModificar);

      if($resultadoModificar){
        $mensaje ="Se modificó al $rol $nombres $apellidos exitosamente ";
      }
      else{
          $error = "Falló modificar al $rol ";
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
</head>

<body class="fondo">
  <!-- Barra de navegacion oscura -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">
        UDENAR TESISS
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              OPCIONES
            </a>
            <?php if($tipo == 1) {?>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="listadoE.php">MOSTRAR ESTUDIANTES </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="listadoD.php">MOSTRAR DOCENTES</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="listadoT.php">MOSTRAR TESIS</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="perfilA.php">PERFIL</a>
          </li>
          <?php }else{ ?>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="agregarTesis.php">
              <?php if($id_Tesis>0) echo 'MODIFICAR TESIS';
              
              else{ echo 'REGISTRO DE TESIS'; }?>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="visualizarTesisE.php">VISUALIZAR TESIS</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="eliminarTesis.php">ELIMINAR TESIS</a>
          </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="perfilE.php">PERFIL</a>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#logout" href="#">SALIR</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Barra de navegacion oscura -->

  <div class="container p-4">
    <div class="row">
      <div class="col-md-4 mx-auto">
        <div class="card text-center">
          <div class="card-header">
            <h3>MODIFICAR DATOS</h3>
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

          <div class="form-group">
            <div class="col-sm-6 mx-auto">Mostrar
              <a class="btn btn-primary btn-block" <?php if($tipo==1) {?> href="listadoE.php">ESTUDIANTES</a>
              <?php }else {?> href="perfilE.php">Ver Perfil</a>
              <?php } ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Logout Modal-->
  <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Seguro quieres cerrar sesión?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Volver</button>
          <a class="btn btn-primary" href="logout.php">Cerrar Sesión</a>
        </div>
      </div>
    </div>
  </div>

  <!-- SCRIPTS -->
  <script src="scripts/jquery-3.3.1.slim.min.js"></script>
  <script src="scripts/popper.min.js"></script>
  <script src="scripts/bootstrap.min.js"></script>
</body>

</html>