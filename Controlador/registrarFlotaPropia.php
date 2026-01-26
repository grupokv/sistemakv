<?php
include 'Sesion/autenticar.php';
require_once("../Modelo/FlotaPropia.php");

$id_vehiculo = $_POST['id_vehiculo'];
$id_contrato_fijo = $_POST['id_contrato_fijo'];
$id_contrato_ocasional = $_POST['id_contrato_ocasional'];
$id_vehiculo = $_POST['id_vehiculo'];
$numero_recorridos = $_POST['numero_recorridos'];
$dias_laborados = $_POST['dias_laborados'];
$dias_laborados_gps = $_POST['dias_laborados_gps'];
$valor_generado = $_POST['valor_generado'];
$fecha_creacion = date('Y-m-d');
$fecha_movimiento = $_POST['fecha_movimiento'];

$flotaPropia = new FlotaPropia();
$registrarFP = $flotaPropia->registrarDetalleFlotaPropia($id_vehiculo, $id_contrato_fijo, $id_contrato_ocasional,  
	                                                     $numero_recorridos, $dias_laborados, $dias_laborados_gps, 
	                                                     $valor_generado, $fecha_creacion, $fecha_movimiento);

 ?>