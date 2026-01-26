<?php 

include ("Sesion/autenticar.php");
require_once("../Modelo/Correspondencia.php");

$detalle = mb_strtoupper($_POST['detalle']);
$remitente = mb_strtoupper($_POST['remitente']);
$destino = mb_strtoupper($_POST['destino']);
$tipo = $_POST['id_tipo'];
$fecha_recibido = $_POST['fecha_recibido'];
$us_destino = $_POST['us_destino'];
$hoy = date('Y-m-d H:i:s');
$id_usuario = $_SESSION['id_usuario'];

$correspondencia = new Correspondencia();
$registrarC = $correspondencia->registrar($tipo, $detalle, $fecha_recibido, $remitente, $destino, $hoy, $id_usuario, $us_destino);

/*$id_modulo = 7; 
$id_registro = $registrarC;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_cargo | nombre_cargo | id_area | id_empresa';
$valores_antiguos = '';
$valores_nuevos = $registrarC . ' | ' .$nombre_cargo . ' | ' . $id_area . ' | '. $id_empresa;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s'); 

$bitacoraRegistroCargo = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);*/

header('Location: ../Vista/correspondencia.php');
?>