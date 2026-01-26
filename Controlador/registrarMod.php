<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Modulo.php");
require_once("../Modelo/General.php");

$nombre_modulo = $_POST['nombre_modulo'];
$modulo_padre = $_POST['modulo_padre'];
$menu = $_POST['menu'];
$link = $_POST['link'];

if ($modulo_padre == 2) {
	$id_padre = 0;
}else{
	$id_padre = $_POST['id_padre'];;
}


$modulo = new Modulo();
$registrar = $modulo->registrar($nombre_modulo, $id_padre, $link, $menu);

$estado = 1;

if ($modulo_padre == 1) {
	
	$id_modulo = 9;
	$id_registro = $registrar;
	$tipo_actividad = 'REGISTRAR';
	$columnas_modulo = 'id_modulo | nombre_modulo | estado | id_padre | link  | menu ';
	$valores_antiguos = '';
	$valores_nuevos = 	$registrar . ' | ' . $nombre_modulo . ' | ' . $estado . ' | ' .  $id_padre . ' | ' . $link . ' | ' . $menu;
	$id_usuario = $_SESSION['id_usuario'];
	$fecha_actividad = date('Y-m-d');
	$hora_actividad = date('H:i:s');
    
}else if ($modulo_padre == 2) {

	$id_padre = 0;
	$link = '';

	$id_modulo = 9;
	$id_registro = $registrar;
	$tipo_actividad = 'REGISTRAR';
	$columnas_modulo = 'id_modulo | nombre_modulo | estado | id_padre | link | menu ';
	$valores_antiguos = '';
	$valores_nuevos = 	$registrar . ' | ' . $nombre_modulo . ' | ' . $estado . ' | ' .  $id_padre . ' | ' . $link . ' | ' . $menu;
	$id_usuario = $_SESSION['id_usuario'];
	$fecha_actividad = date('Y-m-d');
	$hora_actividad = date('H:i:s');
}

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/modulos.php');


 ?>