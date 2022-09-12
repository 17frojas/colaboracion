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

$sql="SELECT * FROM  estudiantes WHERE id = $Id_Usuario";
    $resultado = $mysqli-> query ($sql);
while ($row=$resultado->fetch_assoc() ) {
    $nombre = $row['nombres'].' '.$row['apellidos'];
    $id_Tesis=$row['idTesis'];
}
$sqlDocentes="SELECT * FROM  docentes";
$resultadoDocentes = $mysqli-> query ($sqlDocentes);
   
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
            <?php if($id_Tesis>0){
                     echo '<h3>Subir nuevo Archivo</h3>';

                  }else{
                    echo '<h3>Subir Archivo</h3>';

                  } ?>
          </div>
          <div class="card-body">
            <form method="POST" action="upload.php" enctype="multipart/form-data">
              <div class="form-group">
                <input type="text" name="nombreProyecto" placeholder="Nombre del proyecto" class="form-control"
                  autofocus>
              </div>
              <div class="form-group">
                Selecciona Asesor : <select name="asesor" id="asesor" class="form-control">
                  <option value="">Seleccionar Asesor</option>
                  <?php while($row = $resultadoDocentes->fetch_assoc()) { ?>
                        <option value="<?php echo $row['nombres'].' '.$row['apellidos']; ?>">
                          <?php echo $row['nombres'].' '.$row['apellidos']; ?>
                        </option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <textarea name="descripcion" rows="2" class="form-control" placeholder="Descripción"></textarea>
              </div>
              <div class="form-group">
                <input type="file" name="file" id="file" placeholder="Documento" class="form-control">

              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">
                  Subir Tesis
                </button>
              </div>
            </form>
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
