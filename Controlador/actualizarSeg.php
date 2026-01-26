<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Segmento.php");
require_once("../Modelo/General.php");

$id_segmento = $_POST['id_segmento'];
$detalle = $_POST['detalle'];
$detalle_act = $_POST['detalle_act'];

$segmento = new Segmento();
$actualizar = $segmento->actualizar($id_segmento, $detalle);

$id_modulo = 10;
$id_registro = $id_segmento;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

if ($detalle != $detalle_act) {
	$columnas_modulo .=  'detalle';
	$valores_antiguos .= $detalle_act . ' | ';
	$valores_nuevos .= $detalle . ' | ';
}

if($columnas_modulo != ''){
$bitacoraActualizarSegmento = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);
}
header('Location: ../Vista/segmentos.php');
?>