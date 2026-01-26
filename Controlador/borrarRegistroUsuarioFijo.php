<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/UsuarioContratoFijo.php");

$datos = new UsuarioContratoFijo();

$id = $_POST['id'];

if (!isset($id)) {
	echo "<script>
    window.location.href='../Vista/usuariosContratosFijos.php';
    </script>";
    exit();
} else {
	
	$borrar = $datos->borrarUsuarioContrato($id);
	
}

 ?>