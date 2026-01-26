<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Cartera.php");
require_once("../Modelo/General.php");

$id_vehiculo = $_POST['id_vehiculo_acuerdo'];
$fecha_pago = $_POST['fecha_pago'];
$valor = $_POST['valor'];
$id_usuario = $_SESSION['id_usuario'];

$hoy = date('Y-m-d H:i:s');
$estado = 1;

$cartera = new Cartera();
$registrar = $cartera->registrarAcuerdo($id_vehiculo, $valor, $fecha_pago, $id_usuario, $hoy, $estado, $hoy);

$id_modulo = 130;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_acuerdo' . ' | ' . 'id_vehiculo' . ' | ' . 'fecha' . ' | ' . 'valor';
$valores_antiguos =  '';
$valores_nuevos = $registrarArea . ' | '. $id_vehiculo . ' | '  . $fecha . ' | '. $valor;

$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraArea = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);

header('Location: ../Vista/cobro_cartera.php');

?>