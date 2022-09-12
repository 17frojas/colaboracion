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
$nom_D="";
$nom_E="";
$id_Tesis=$_GET['idT'];
$id_Est=$_GET['idE'];
$sqlTesis = "SELECT * FROM tesis WHERE numTesis='$id_Tesis'";
$resultadoTesis = $mysqli-> query ($sqlTesis);
$sqlDocentes = "SELECT * FROM docentes";
$resultadoDocentes = $mysqli-> query ($sqlDocentes);
  


if($_POST){   
  $idJurado = $_POST['jurado'];
  if(camposVaciosJurado($idJurado)){
      $error = "Debe seleccionar un jurado para ser asignado";
  }else{
    $sql = "UPDATE tesis SET idDocente='$idJurado' WHERE numTesis='$id_Tesis'";
    $resultado=$mysqli->query($sql);
    if($resultado){
      $mensaje="Se asignó el jurado exitosamente";
      $sql2 = "UPDATE estudiantes SET idDocente='$idJurado' WHERE id = '$id_Est'";
      $resultado2=$mysqli->query($sql2);

      $sql3 = "UPDATE docentes SET idEstudiante='$id_Est', idTesis='$id_Tesis'  WHERE id = '$idJurado'";
      $resultado3=$mysqli->query($sql3);     
    }else{
      $error = 'No se pudo asignar';
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
  <link rel="stylesheet" href=css/styles.css">
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
    <div class="card text-center">
      <div class="card-header">
        <h3>ASIGNACIÓN DE JURADO</h3>
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

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Id Tesis</th>
                <th>Estudiante</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Asesor</th>
                <th>Jurado</th>
                <th>Calificación</th>
                <th>Observaciones</th>
              </tr>
            </thead>

            <tbody>
              <?php 
                $sqlTesis = "SELECT * FROM tesis WHERE numTesis='$id_Tesis'";
                $resultadoTesis = $mysqli-> query ($sqlTesis); 
                while ($row=$resultadoTesis->fetch_assoc() ) { 
                  $idD= $row['idDocente']; 
                  $idE= $row['idE']; 
              ?>
              <tr>
                <td>
                  <?php echo $row['numTesis'] ?>
                </td>
                <td>
                  <?php 
                    $sqlEst = "SELECT * FROM estudiantes WHERE id='$idE'";
                    $resultadoEst = $mysqli-> query ($sqlEst);
                    while ($row2=$resultadoEst->fetch_assoc() ) {
                    $nom_E=$row2['nombres'].' '.$row2['apellidos'];
                    }
                    echo $nom_E; 
                  ?>
                </td>
                <td>
                  <?php echo $row['nombre']; ?>
                </td>
                <td>
                  <?php echo $row['descripcion']; ?>
                </td>
                <td>
                  <?php echo $row['asesor']; ?>
                </td>
                <td>
                  <?php $sqlDoc = "SELECT * FROM docentes WHERE id='$idD'";
                    $resultadoDoc = $mysqli-> query ($sqlDoc);
                    while ($row2=$resultadoDoc->fetch_assoc() ) {
                    $nom_D=$row2['nombres'].' '.$row2['apellidos'];
                    }
                    echo $nom_D;  
                  ?>
                </td>
                <td>
                  <?php echo $row['calificacion']; ?>
                </td>
                <td>
                  <?php echo $row['comentarios']; ?>
                </td>

              </tr>

              <?php } ?>
            </tbody>
          </table>

          <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
              Seleccionar Jurado : <select name="jurado" id="jurado" class="form-control">
                <option value="">Seleccionar Jurado</option>
                <?php while($row2 = $resultadoDocentes->fetch_assoc()) { ?>
                  <option value="<?php echo $row2['id']; ?>">
                    <?php echo $row2['nombres'].' '.$row2['apellidos']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success btn-block">
                Asignar
              </button>
            </div>
          </form>


        </div>
        <div class="form-group">
          <a class="btn btn-primary btn-block" href="listadoT.php">Regresar</a>
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
