<?php 
require_once '../Modelo/Programacion.php';

$programacion = new Programacion();

$id_servicio = $_GET['id_s'];

$datos_servicio = $programacion->serviciosPorIdDetalle($id_servicio);
$actualizar = $programacion->cambiarEstadoServicio($id_servicio);
$datos_solicitud = $programacion->solicitudPorId($datos_servicio[0]['id_solicitud']);
$id_solicitud = $datos_servicio[0]['id_solicitud'];

if($datos_servicio[0]['tipo'] == 'IDA'){
	$cant = ($datos_solicitud[0]['servicios_ida'] - 1);
	$act = $programacion->actualizarCantidadIdas($id_solicitud,$cant);
} else if ($datos_servicio[0]['tipo'] == 'VUELTA'){
	$cant = ($datos_solicitud[0]['servicios_retorno'] - 1);
	$act = $programacion->actualizarCantidadRetornos($id_solicitud,$cant);
}
header('Location: ../Vista/asignaciones.php');
?>