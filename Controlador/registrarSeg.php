<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Segmento.php");
require_once("../Modelo/General.php");


$detalle = mb_strtoupper($_POST['detalle']);

$segmento = new Segmento();
$registrar = $segmento->registrar($detalle);

$id_modulo = 10;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_segmento | detalle';
$valores_antiguos = '';
$valores_nuevos = 	$registrar . ' | ' . $detalle;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/segmentos.php');

 ?>