<?php

function camposVaciosLogin($usuario,$pass){
	if(strlen(trim($usuario)) < 1 || strlen(trim($pass)) < 1)
    {
        return true;
        } else {
        return false;
    }	
}

function camposVaciosTesis($nombre,$asesor,$descripcion){
	if(strlen(trim($nombre)) < 1 || strlen(trim($asesor)) < 1|| strlen(trim($descripcion)) < 1)
    {
        return true;
        } else {
        return false;
    }	
}

function camposVaciosEst($nombres, $apellidos, $email, $cedula, $codigo, $celular, $rol, $programa, $sede, $username, $password){
	if(strlen(trim($nombres)) < 1 || strlen(trim($apellidos)) < 1 || strlen(trim($email)) < 1 || strlen(trim($cedula)) < 1 || strlen(trim($celular)) < 1 || strlen(trim($rol)) < 1 || strlen(trim($programa)) < 1 || strlen(trim($sede)) < 1 || strlen(trim($username)) < 1 || strlen(trim($password)) < 1)
    {
        return true;
        } else {
        return false;
    }	
}

function camposVaciosJurado($idJurado){
    if(strlen(trim($idJurado)) < 1)
    {
        return true;
        } else {
        return false;
    }
}

function camposVaciosComentarios($calificacion, $comentarios)
{
    if(strlen(trim($calificacion)) < 1 || strlen(trim($comentarios)) < 1 )
    {
        return true;
        } else {
        return false;
    }
}

function camposVaciosDoc($nombres, $apellidos, $email, $cedula,$codigo, $celular, $rol, $username, $password){
	if(strlen(trim($nombres)) < 1 || strlen(trim($apellidos)) < 1 || strlen(trim($email)) < 1 || strlen(trim($cedula)) < 1 || strlen(trim($celular)) < 1 || strlen(trim($rol)) < 1 || strlen(trim($username)) < 1 || strlen(trim($password)) < 1)
    {
        return true;
        } else {
        return false;
    }	
}

function isEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
			} else {
			return false;
		}
	}

function usuarioExiste($usuario)
{
    global $mysqli;
    
    $stmt = $mysqli->prepare("SELECT id FROM administrador WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    $stmt->close();

    if ($num > 0){
        return true;
    } else {
        $stmt = $mysqli->prepare("SELECT id FROM estudiantes WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows;
        $stmt->close();

        if ($num > 0){
            return true;
        } else {    
            $stmt = $mysqli->prepare("SELECT id FROM docentes WHERE username = ? LIMIT 1");
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $stmt->store_result();
            $num = $stmt->num_rows;
            $stmt->close();
            if ($num > 0){
                return true;
            } else {    
                return false;
            }
        }
    }
}

function eliminarDir($carpeta){
    foreach(glob($carpeta . "/*") as $archivo_carpeta){
        if(is_dir($archivo_carpeta)){
            eliminarDir($archivo_carpeta);
        }else{
            unlink($archivo_carpeta);
        }
    }
    rmdir($carpeta);
}

?>