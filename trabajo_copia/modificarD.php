<?php
require 'conexion.php';
require 'validations.php';

session_start();
$error = "";
$mensaje = "";

$Id_Usuario = $_GET['id'];
$tipo = $_GET['tipo'];

$sql = "SELECT * FROM docentes WHERE id=$Id_Usuario";
$resultado = $mysqli-> query ($sql);
while ($row=$resultado->fetch_assoc() ) {
$Id = $row['id'];
$Cedula = $row['cedula'];
$Nombre_Usuario = $row['username'];
$Contras = $row['password'];
$Codigo = $row['codigo'];
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

<body class="udenar">

  <div class="container p-4">


    <div class="card text-center">
      <div class="card-header">
        <h3>Modificar Datos</h3>
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
      </div>
      <div class="card-body">
        <form action="updateD.php?id=<?php echo $Id; ?>&tipo=<?php echo $tipo; ?>" method="POST">
          <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <input type="type" name="nombres" placeholder="Nombres" class="form-control"
                value="<?php echo $Nombres; ?>" autofocus>
            </div>
            <div class="col-sm-6">
              <input type="type" name="apellidos" placeholder="Apellidos" class="form-control"
                value="<?php echo $Apellidos; ?>">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <input type="number" name="cedula" placeholder="Documento de identidad" class="form-control"
                value="<?php echo $Cedula; ?>">
            </div>
            <div class="col-sm-6">
              <input type="number" name="celular" placeholder="Celular" class="form-control"
                value="<?php echo $Celular; ?>">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <input type="email" name="email" placeholder="Correo Electrónico" class="form-control"
                value="<?php echo $Correo; ?>">

            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
              <input type="number" name="codigo" placeholder="Código" class="form-control"
                value="<?php echo $Codigo; ?>">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <input type="text" name="username" placeholder="Usuario" class="form-control"
                value="<?php echo $Nombre_Usuario; ?>">
            </div>
            <div class="col-sm-6">
              <input type="password" name="password" placeholder="Contraseña" class="form-control"
                value="<?php echo $Contras; ?>">
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-success btn-block">
              Modificar Datos
            </button>
          </div>
          <div class="form-group">
            <a class="btn btn-primary btn-block" <?php if($tipo==1) {?>href="listadoD.php"
              <?php }else {?>href="perfilD.php"
              <?php } ?> >Regresar
            </a>
          </div>



        </form>
      </div>
    </div>


  </div>

  <!-- SCRIPTS -->
  <script src="scripts/jquery-3.3.1.slim.min.js"></script>
  <script src="scripts/popper.min.js"></script>
  <script src="scripts/bootstrap.min.js"></script>
</body>

</html>
