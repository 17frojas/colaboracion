<?php
require 'conexion.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location:login.php");
}
$Id_Usuario = $_SESSION['id'];
$Nombre_Usuario = $_SESSION['username'];
$Tipo_Usuario = $_SESSION['tipoUser'];
$sql = "SELECT * FROM estudiantes";
$resultado = $mysqli-> query ($sql);

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
      <a class="navbar-brand" href="perfilA.php">
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
        <h3 class="card-title text-uppercase">Estudiantes registrados</h3>
      </div>
      <div class="card-body">

        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Usuario</th>
                <th>Password</th>
                <th>Código</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Identificación</th>
                <th>Celular</th>
                <th>Correo</th>
                <th>Sede</th>
                <th>Programa</th>
                <th>Fecha Registro</th>

              </tr>
            </thead>

            <tbody>
              <?php while ($row=$resultado->fetch_assoc() ) { ?>
              <tr>
                <td>
                  <?php echo $row['username'] ?>
                </td>
                <td>
                  <?php echo $row['password']; ?>
                </td>
                <td>
                  <?php echo $row['codigo']; ?>
                </td>
                <td>
                  <?php echo $row['nombres']; ?>
                </td>
                <td>
                  <?php echo $row['apellidos']; ?>
                </td>
                <td>
                  <?php echo $row['cedula']; ?>
                </td>
                <td>
                  <?php echo $row['celular']; ?>
                </td>
                <td>
                  <?php echo $row['correo']; ?>
                </td>
                <td>
                  <?php echo $row['sede']; ?>
                </td>
                <td>
                  <?php echo $row['programa']; ?>
                </td>
                <td>
                  <?php echo $row['fecha']; ?>
                </td>
                <td> <a class="btn btn-secondary" href="modificarE.php?id=<?php echo $row['id']; ?>&tipo=1">Editar</a>
                </td>
                <td> <a class="btn btn-danger" href="eliminar.php?id=<?php echo $row['id']; ?>&tipo=2">Eliminar</a>
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