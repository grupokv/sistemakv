<?php 

include ("Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
include("../Modelo/General.php");


$id_cliente = $_POST['id_cliente'];
$idas = $_POST['idas'];
$retornos = $_POST['retornos'];
$creador = $_SESSION['id_usuario'];
$estado =  'P';
$fecha = date('Y-m-d H:i:s');

$programacion = new Programacion();

$registrar = $programacion->registrar($idas, $retornos, $fecha, $id_cliente, $creador, $estado);

$id_modulo = 31;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_solicitud | servicios_ida | servicios_retorno | fecha_solicitud | id_cliente | id_usuario | estado';

$valores_antiguos = '';
$valores_nuevos = $registrar . ' | ' . $idas . ' | ' . $retornos . ' | ' . $fecha . ' | ' . $id_cliente . ' | ' . $creador . ' | ' . $estado;

$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $creador, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/registrarServicio.php?ids='.$registrar);
?>