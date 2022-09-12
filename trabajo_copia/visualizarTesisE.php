<?php
require 'conexion.php';

session_start();

if (!isset($_SESSION['id'])) {
    header("Location:login.php");
}
$Id_Usuario = $_SESSION['id'];
$Nombre_Usuario = $_SESSION['username'];
$Tipo_Usuario = $_SESSION['tipoUser'];
$nombre="";
$nombres="";
$apellidos="";
$id_Tesis=0;
$id_doc=0;
$calificacion = "";

$sql="SELECT * FROM  estudiantes WHERE id = $Id_Usuario";
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
    $id_doc=$row['idDocente'];
    $calificacion=$row['calificacion'];
    $comentarios=$row['comentarios'];
  }
}
if( $id_doc>0 ){
  $sqlDocente="SELECT * FROM  docentes WHERE id = $id_doc";
  $resultadoDocente = $mysqli-> query ($sqlDocente);
  while ($row=$resultadoDocente->fetch_assoc() ) {
    $nombres = $row['nombres'];
    $apellidos=$row['apellidos'];
    $correo=$row['correo'];
    $celular=$row['celular'];
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

    <?php if($nombre!=''){ ?>
    <div class="card text-center">
      <div class="card-header">
        <h3 class="card-title text-uppercase">Visualizar Tesis guardada</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">

          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Asesor</th>
                <th>Jurado Revisor</th>
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
                  <?php echo $nombres.' '.$apellidos; ?>
                </td>
                <td>
                  <?php echo $calificacion; ?>
                </td>
                <td>
                  <?php echo $comentarios; ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php if($id_doc>0){ ?>
    <div class="card text-center">
      <div class="card-header">
        <h3 class="card-title text-uppercase">Información del docente asignado</h3>
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
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php }else{
            echo '<div class="card text-center">
                    <div class="card-header">
                      <h3>¡Aún no hay jurado revisor!</h3>
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

    <?php }else{
            echo '<div class="card text-center">
                    <div class="card-header">
                      <h3>Primero debe subir Tesis</h3>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-6 mx-auto" >Ir a Registro de Tesis
                        <a class="btn btn-primary btn-block" href="agregarTesis.php">Registrar Tesis</a>
                      </div>
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