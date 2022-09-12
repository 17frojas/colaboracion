<?php
require 'conexion.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location:login.php");
}
$Id_Usuario = $_SESSION['id'];
$Nombre_Usuario = $_SESSION['username'];
$Tipo_Usuario = $_SESSION['tipoUser'];

$sql = "SELECT * FROM tesis";
$resultado = $mysqli-> query ($sql);
$sqlDocentes = "SELECT * FROM docentes";
$resultadoDocentes = $mysqli-> query ($sqlDocentes);
$nom_D="";
$nom_E="";


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

  <!-- TABLA DE ESTUDIANTES -->
  <div class="container p-4">
    <div class="card text-center">
      <div class="card-header">
        <h3 class="card-title text-uppercase">Listado De Proyectos registrados</h3>
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
                <th>ID Jurado</th>
                <th>Calificación</th>
                <th>Observaciones</th>
              </tr>
            </thead>

            <tbody>
              <?php while ($row=$resultado->fetch_assoc() ) {
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
                    echo $nom_E; ?>
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
                  <?php
            
                    $sqlDoc = "SELECT * FROM docentes WHERE id='$idD'";
                    $resultadoDoc = $mysqli-> query ($sqlDoc);
                    while ($row2=$resultadoDoc->fetch_assoc() ) {
                    $nom_D=$row2['nombres'].' '.$row2['apellidos'];
                    }
                    echo $nom_D; ?>
                </td>
                <td>
                  <?php echo $row['calificacion']; ?>
                </td>
                <td>
                  <?php echo $row['comentarios']; ?>
                </td>

                <td> <a class="btn btn-success btn-block"
                    href="asignacion.php?idE=<?php echo $row['idE']; ?>&idT=<?php echo $row['numTesis'] ?>">Asignar un
                    jurado</a>
                </td>

              </tr>
              <?php } ?>
            </tbody>
          </table>

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