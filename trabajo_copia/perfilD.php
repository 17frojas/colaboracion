<?php
require 'conexion.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location:login.php");
}
$Id_Usuario = $_SESSION['id'];
//$Nombre_Usuario = $_SESSION['username'];
$Tipo_Usuario = $_SESSION['tipoUser'];
$nombre="";
$sql = "SELECT * FROM docentes WHERE id=$Id_Usuario";
$resultado = $mysqli-> query ($sql);
while ($row=$resultado->fetch_assoc() ) {

$Id = $row['id'];
$Cedula = $row['cedula'];
$codigo = $row['codigo'];

$Nombre_Usuario = $row['username'];
$Nombres = $row['nombres'];
$Apellidos = $row['apellidos'];
$Correo = $row['correo'];
$Celular = $row['celular'];
$Rol = $row['rol'];

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

    <div class="card text-center">
      <div class="card-header">
        <h3 class="card-title text-uppercase">Información del Usuario</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">

          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Identificación</th>
                <th>Código</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Celular</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>
                  <?php echo $Cedula; ?>
                </td>
                <td>
                  <?php echo $codigo; ?>
                </td>
                <td>
                  <?php echo $Nombres; ?>
                </td>
                <td>
                  <?php echo $Apellidos; ?>
                </td>
                <td>
                  <?php echo $Correo; ?>
                </td>
                <td>
                  <?php echo $Celular; ?>
                </td>
              </tr>
            </tbody>
          </table>


        </div>
      </div>
      <div class="container p-4">
        <div class="card text-center">
          <div class="card-header">

            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
              <a href="modificarD.php?id=<?php echo $Id; ?>&tipo=3 "> Modificar Datos </a>
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