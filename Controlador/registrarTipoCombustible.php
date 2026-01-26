<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/TipoCombustible.php");
require_once("../Modelo/General.php");

$detalle = mb_strtoupper($_POST['nombre_tipo']);

$tipocombustible = new TipoCombustible();

$registrar = $tipocombustible->registrar($detalle);

$id_modulo = 126;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_tipo | detalle';
$valores_antiguos = '';
$valores_nuevos = 	$registrar . ' | ' . $detalle;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/tipo_combustible.php');

 ?>