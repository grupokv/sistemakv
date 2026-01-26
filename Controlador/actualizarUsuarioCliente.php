<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/General.php");

$id_usu = $_POST['id_usuario'];
$nombre_usu = mb_strtoupper($_POST['nombre_usu']);
$clave = base64_encode($_POST['clave']);
$id_centro_costo = $_POST['id_centro_costo];
$correo_electronico = mb_strtoupper($_POST['correo_electronico']);
$nombre = mb_strtoupper($_POST['nombre']);
$id_cargo = $_POST['id_cargo'];

$usuario = new Usuario();
$actualizar = $usuario->actualizarUC($id_usu, $nombre_usu, $clave, $id_centro_costo, $correo_electronico, $nombre, $id_cargo);

header('Location: ../Vista/usuarios_clientes.php');
?>