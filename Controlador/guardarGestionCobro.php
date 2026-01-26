<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Cartera.php");
require_once("../Modelo/General.php");

$id_vehiculo = $_POST['id_veh_gestion'];
$tipo_contacto = $_POST['tipo_contacto'];
$detalle_contacto = $_POST['detalle_contacto'];
$id_usuario = $_SESSION['id_usuario'];

$hoy = date('Y-m-d H:i:s');

$cartera = new Cartera();
$registrar = $cartera->registrarGestion($id_vehiculo, $hoy, $tipo_contacto, $detalle_contacto, $id_usuario);

$id_modulo = 129;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_gestion' . ' | ' . 'id_vehiculo' . ' | ' . 'fecha' . ' | ' . 'tipo_contacto' . ' | ' . 'detalle';
$valores_antiguos =  '';
$valores_nuevos = $registrarArea . ' | '. $id_vehiculo . ' | '  . $fecha . ' | '. $tipo_contacto . ' | '. $detalle_contacto;

$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraArea = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);

header('Location: ../Vista/cobro_cartera.php');

?>