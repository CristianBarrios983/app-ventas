<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Usuarios.php";

    $obj= new usuarios();

    $pass=sha1($_POST['password']);
    $datos=array(
        $_POST['rol'],
        $_POST['nombre'],
        $_POST['apellido'],
        $_POST['usuario'],
        $_POST['email'],
        $pass
                );
    echo $obj->registroUsuario($datos);
?>