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
$id_Tesis=0;
$id_est=0;
$calificacion = "";
$error = "";
$mensaje = "";
$sql="SELECT * FROM  docentes WHERE id = $Id_Usuario";
$resultado = $mysqli-> query ($sql);
while ($row=$resultado->fetch_assoc() ) {
    $id_Tesis=$row['idTesis'];
}

if( $id_Tesis>0 ){
  $sqlTesis="SELECT * FROM  tesis WHERE numTesis = $id_Tesis";
  $resultadoTesis = $mysqli-> query ($sqlTesis);
  while ($row=$resultadoTesis->fetch_assoc() ) {
    $nombre = $row['nombre'];
    $descripcion=$row['descripcion'];
    $url=$row['url'];
    $descripcion=$row['descripcion'];
    $asesor=$row['asesor'];
    $id_est=$row['idE'];
    $calificacion=$row['calificacion'];
    $Coments=$row['comentarios'];
  }
}
if( $id_est>0 ){
  $sqlEstudiante="SELECT * FROM  estudiantes WHERE id = $id_est";
  $resultadoEstudiante = $mysqli-> query ($sqlEstudiante);
  while ($row=$resultadoEstudiante->fetch_assoc() ) {
    $nombres = $row['nombres'];
    $apellidos=$row['apellidos'];
    $correo=$row['correo'];
    $celular=$row['celular'];
    $programa=$row['programa'];
    $sede=$row['sede'];
  }
}

////////////////////
if($_POST){
  $calificacion = $_POST['calificacion'];
  $comentarios = $Coments.'. '.$_POST['comentarios'];
  if(camposVaciosComentarios($calificacion, $comentarios)){
    $error = "Debe agregar una calificación";
  }else{
    $sqlTesis = "UPDATE tesis SET calificacion='$calificacion', comentarios='$comentarios' WHERE numTesis='$id_Tesis'";
    $resultadoTesis=$mysqli->query($sqlTesis);
    if($resultadoTesis){
      $mensaje ="Se registró su calificación exitosamente ";
    }
    else{
        $error = "Falló registrar";
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
          <li class="nav-item">
            <a class="nav-link" href="visualizarTesisD.php">REVISAR TESIS ASIGNADA</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="perfilD.php">PERFIL</a>
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
    <?php if($id_Tesis>0){
    ?>
    <div class="card text-center">
      <div class="card-header">
        <h3 class="card-title text-uppercase">Visualizar Tesis asignada</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">

          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Asesor</th>
                <th>Calificación</th>
                <th>Observaciones</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>
                  <?php echo $nombre; ?>
                </td>
                <td>
                  <?php echo $descripcion; ?>
                </td>
                <td>
                  <?php echo $asesor; ?>
                </td>
                <td>
                  <?php 
                    $sqlTes="SELECT * FROM  tesis WHERE numTesis = $id_Tesis";
                    $resultadoTes = $mysqli-> query ($sqlTes);
                    while ($row=$resultadoTes->fetch_assoc()){ 
                      $Coments=$row['comentarios']; $calificacion=$row['calificacion'];
                    }

                    echo $calificacion; ?>
                </td>
                <td>
                  <?php echo $Coments; ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php if($id_est>0){ ?>
    <div class="card text-center">
      <div class="card-header">
        <h3 class="card-title text-uppercase">Visualizar datos del Estudiante</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Celular</th>
                <th>Programa</th>
                <th>Sede</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <?php echo $nombres; ?>
                </td>
                <td>
                  <?php echo $apellidos; ?>
                </td>
                <td>
                  <?php echo $correo; ?>
                </td>
                <td>
                  <?php echo $celular; ?>
                </td>
                <td>
                  <?php echo $programa; ?>
                </td>
                <td>
                  <?php echo $sede; ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php }else{
            echo '<div class="card text-center">
                    <div class="card-header">
                      <h3>¡Aún no eres jurado revisor!</h3>
                    </div>
                  </div>';
          } ?>


    <div class="card text-center">
      <div class="card-header">
        <h3 class="card-title text-uppercase">Haga clic en el nombre de la TESIS</h3>
      </div>
      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
        <a href="<?php echo $url;?> " target="_blank">
          <?php echo 'Visualizar Tesis: '.$nombre; ?>
        </a>
        <hr>
      </div>
    </div>
    <div class="card text-center">
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

      <div class="card-header">
        <h3 class="card-title text-uppercase">Registrar Calificación y comentarios</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
          <div class="form-group row">

            <div class="col-sm-6  mb-3 mb-sm-0">
              <label for="calificacion">Calificación</label>
              <input type="number" name="calificacion" id="calificacion" placeholder="Ingrese la calificación de 0 a 5"
                min="0" max="5" class="form-control">
            </div>
          </div>
          <hr>
          <div class="form-group">
            <label for="comentarios">Comentarios</label>
            <textarea name="comentarios" id="comentarios" placeholder="Ingrese su comentario..." cols="80" rows="5"
              class="form-control"></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success btn-block">
              Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
    <?php }else{
            echo '<div class="card text-center">
                    <div class="card-header">
                      <h3>¡Aún no eres jurado revisor!</h3>
                    </div>
                  </div>';
          } ?>

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
