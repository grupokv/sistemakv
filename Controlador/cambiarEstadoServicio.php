<?php
include ("Sesion/autenticar.php");
require_once '../Modelo/Programacion.php';

$programacion = new Programacion();

$id_servicio = $_POST['id_serv'];
$id_solicitud = $_POST['id_sol'];
$fecha = date('Y-m-d H:i:s');
$detalle = $_POST['novedad_finalizacion'];
$usuario = $_SESSION['id_usuario'];

$datos_servicio = $programacion->serviciosPorIdDetalle($id_servicio);
$actualizar = $programacion->cambiarEstadoServicio($id_servicio);
$datos_solicitud = $programacion->solicitudPorId($datos_servicio[0]['id_solicitud']);
$id_solicitud = $datos_servicio[0]['id_solicitud'];

$guardar = $programacion->guardarDetalle($id_solicitud,$id_servicio,$detalle,$usuario,$fecha);

if($datos_servicio[0]['tipo'] == 'IDA'){
	$cant = ($datos_solicitud[0]['servicios_ida'] - 1);
	$act = $programacion->actualizarCantidadIdas($id_solicitud,$cant);
} else if ($datos_servicio[0]['tipo'] == 'VUELTA'){
	$cant = ($datos_solicitud[0]['servicios_retorno'] - 1);
	$act = $programacion->actualizarCantidadRetornos($id_solicitud,$cant);
}
header('Location: ../Vista/programacion_solicitudes.php');
?>