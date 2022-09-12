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
$error="";
$mensaje="";
$id_Tesis=0;
    

$sqlT="SELECT * FROM  tesis WHERE idE = $Id_Usuario";
$resultadoT = $mysqli-> query ($sqlT);

while ($row=$resultadoT->fetch_assoc() ) {
    $id_Tesis = $row['numTesis'];
}


if($_POST){   
  $nombreP = $_POST['nombreProyecto'];
  $asesor = $_POST['asesor'];
  $descripcion = $_POST['descripcion'];
  if(camposVaciosTesis($nombreP,$asesor,$descripcion)){
      $error = "Debe llenar todos los campos";
  }
  else if($_FILES["file"]["error"]>0){
        $error="No se seleccionó un documento ";
  }else{
    $path = 'files';
    if (!is_dir($path)) {
        @mkdir($path);
    }
    $ruta = 'files/'.$Id_Usuario.'/';
    $archivo = $ruta.$_FILES["file"]["name"];
    if(!file_exists($ruta)){
      mkdir($ruta);
    }
    if($id_Tesis>0){
      ////actualizarr
      //$error="El documento ya existía";
      $resulta=@move_uploaded_file($_FILES["file"]["tmp_name"], $archivo);
      if($resulta){
        $sql = "UPDATE tesis SET nombre='$nombreP', descripcion='$descripcion', url='$archivo', asesor='$asesor' WHERE idE='$Id_Usuario'";
        $resultado=$mysqli->query($sql);
        if($resultado){
            $mensaje="Se modificó su tesis exitosamente";
            $sql2 = "UPDATE estudiantes SET idTesis='$id_Tesis' WHERE id = '$Id_Usuario'";
            $resultado2=$mysqli->query($sql2);
        }
                  
      }else{
        $error="Error al guardar archivo";
      }
    }else{
      ///nuevo
      $resulta=@move_uploaded_file($_FILES["file"]["tmp_name"], $archivo);
      if($resulta){
        $sql = "INSERT INTO tesis (idE, nombre, descripcion, url, asesor) VALUES ('$Id_Usuario','$nombreP','$descripcion', '$archivo', '$asesor')";
        $resultado=$mysqli->query($sql);

        if($resultado){
            $mensaje="Se envió su tesis exitosamente";
            $sqlP="SELECT * FROM  tesis WHERE idE = $Id_Usuario";
            $resultadoP = $mysqli-> query ($sqlP);

            while ($row=$resultadoP->fetch_assoc() ) {
                $id_Tesis = $row['numTesis'];
            }
            $sql2 = "UPDATE estudiantes SET idTesis='$id_Tesis' WHERE id = '$Id_Usuario'";
            $resultado2=$mysqli->query($sql2);
        }
                    
      }else{
        $error="Error al guardar archivo";
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
      <a class="navbar-brand" href="inicioE.php">
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
            <h3>Subir Archivo</h3>
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
          <?php if( $error==""){ ?>
          <div class="form-group">
            <div class="col-sm-6 mx-auto">Visualizar
              <a class="btn btn-primary btn-block" href="visualizarTesisE.php">Tesis</a>

            </div>
          </div>
          <?php }else{ ?>
          <div class="form-group">
            <div class="col-sm-6 mx-auto">Reintentar
              <a class="btn btn-primary btn-block" href="agregarTesis.php">Subir Tesis</a>

            </div>
          </div>
          <?php } ?>


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