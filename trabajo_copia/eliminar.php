<?php
require 'conexion.php';
require 'validations.php';
session_start();


if (!isset($_SESSION['id'])) {
  header("Location:login.php");
}
$Id_Usuario = $_SESSION['id'];
$Nombre_Usuario = $_SESSION['username'];
$Tipo_Usuario = $_SESSION['tipoUser'];
$nombre="";
$nom_pro="";
$error="";
$mensaje="";
$id_Tesis=0;
$id_doc=0;
$id_est=0;
$id = $_GET['id'];
$tipo = $_GET['tipo'];


if ($tipo == 2) {////se eliminarĂ¡ un estudiante
  $sql="SELECT * FROM  estudiantes WHERE id = $id";
  $resultado = $mysqli-> query ($sql);

  while ($row=$resultado->fetch_assoc() ) {
      $id_Tesis = $row['idTesis'];
      $id_doc = $row['idDocente'];    
  }
  
  $sqlDelete="DELETE FROM  estudiantes WHERE id = $id";
  $resultadoDelete = $mysqli-> query ($sqlDelete);
  if($id_Tesis>0){
      $sqlTesis="SELECT * FROM  tesis WHERE numTesis = $id_Tesis";
      $resultadoTesis = $mysqli-> query ($sqlTesis);
      while ($row=$resultadoTesis->fetch_assoc() ) {
          $nom_pro = $row['nombre'];    
      }
      
      $sqlDeleteTesis="DELETE FROM  tesis WHERE numTesis = $id_Tesis";
      $resultadoDeleteTesis = $mysqli-> query ($sqlDeleteTesis);
      ////////////////eliminar archivos del estudiante/////
      $ruta = 'files/'.$id.'/';
      if(file_exists($ruta)){
        eliminarDir('files/'.$id);
      }
  }
  if($id_doc>0){
    $sqlDocente="UPDATE docentes SET idEstudiante='', idTesis='' WHERE id = $id_doc";
    $resultadoDocente = $mysqli-> query ($sqlDocente);
  }
  
  if($resultadoDelete){
      $mensaje = "Se eliminĂ³ exitosamente al estudiante";
  }else {
      $mensaje = "No Se eliminĂ³";
  }
}

if ($tipo == 3) {///se va a eliminar un docente
  $sql="SELECT * FROM  docentes WHERE id = $id";
  $resultado = $mysqli-> query ($sql);

  while ($row=$resultado->fetch_assoc() ) {
      $id_Tesis = $row['idTesis'];
      $id_est = $row['idEstudiante'];    
  }
  
  $sqlDelete="DELETE FROM  docentes WHERE id = $id";
  $resultadoDelete = $mysqli-> query ($sqlDelete);
  
  if($id_est>0){
    $sqlDocente="UPDATE estudiantes SET idDocente='' WHERE id = $id_est";
    $resultadoDocente = $mysqli-> query ($sqlDocente);
  }
  if($id_Tesis>0){
    $sqlDeleteTesis="UPDATE  tesis SET idDocente='' WHERE numTesis = $id_Tesis";
    $resultadoDeleteTesis = $mysqli-> query ($sqlDeleteTesis);
  }
  
  if($resultadoDelete){
      $mensaje = "Se eliminĂ³ exitosamente al docente";
  }else {
      $mensaje = "No Se eliminĂ³";
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
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              OPCIONES
            </a>
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
        <div class="text-center">
          <p class="alert-danger"> <?php echo $error; ?></p>
        </div>
        <div class="text-center">
          <p class="alert-primary"> <?php echo $mensaje; ?></p>
        </div>
        <div class="form-group">
          <div class="col-sm-6 mx-auto" >Mostrar
            <a class="btn btn-primary btn-block" <?php if($tipo == 2) {?> href="listadoE.php">ESTUDIANTES</a> <?php }else {?> href="listadoD.php">DOCENTES</a> <?php } ?> 
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
                  <h5 class="modal-title" id="exampleModalLabel">Â¿Seguro quieres cerrar sesiĂ³n?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">Ă—</span>
                  </button>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Volver</button>
                  <a class="btn btn-primary" href="logout.php">Cerrar SesiĂ³n</a>
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
