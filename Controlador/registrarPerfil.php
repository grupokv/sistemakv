<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Perfil.php");
require_once("../Modelo/General.php");

$nombre_perfil = mb_strtoupper($_POST["nombre_perfil"]);

$perfil = new Perfil();
$registrar = $perfil->registrarPerfil($nombre_perfil);


$id_modulo = 8;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_perfil | nombre_perfil';
$valores_antiguos = '';
$valores_nuevos = 	$registrar . ' | ' . $nombre_perfil;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/perfiles.php');

 ?>