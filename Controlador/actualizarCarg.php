<?php 

include ("Sesion/autenticar.php");
require_once("../Modelo/Cargo.php");
require_once("../Modelo/General.php");


$id_cargo = $_POST['id_cargo'];
$nombre_cargo = mb_strtoupper($_POST['nombre_cargo']);
$nombre_cargo_act = mb_strtoupper($_POST['nombre_cargo_act']);
$id_area = $_POST['id_area'];
$id_area_act = $_POST['id_area_act'];
$id_empresa = $_POST['id_empresa'];
$id_empresa_act = $_POST['id_empresa_act'];

$cargo = new Cargo();
$actualizar = $cargo->actualizarCargos($id_cargo, $nombre_cargo, $id_area, $id_empresa);


$id_modulo = 7;
$id_registro = $id_cargo;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

if ($nombre_cargo != $nombre_cargo_act) {
	$columnas_modulo .= 'nombre_cargo | ';
	$valores_antiguos .= $nombre_cargo_act . ' | ';
	$valores_nuevos .= $nombre_cargo . ' | ';
}

if ($id_area != $id_area_act) {
	$columnas_modulo .= 'id_area | ';
	$valores_antiguos .= $id_area_act . ' | ';
	$valores_nuevos .= $id_area . ' | ';
}

if ($id_empresa != $id_empresa_act) {
	$columnas_modulo .= 'id_empresa |';
	$valores_antiguos .= $id_empresa_act . ' | ';
	$valores_nuevos .= $id_empresa . ' | ';
}

if($columnas_modulo != ''){
$bitacoraActualizacionCargo = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);
}

header('Location: ../Vista/cargos.php');
 ?>