<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");

$estado = $_POST['estado'];

if ($estado == 'V') {
	$id_servicio = $_POST['id_servicio'];	
}else if ($estado == 'M') {
	$id_servicio = $_POST['id_servicio1'];
}

$obsEstado = $_POST['observaciones'];

$programacion = new Programacion();
$cambiarEstadoSolicitud = $programacion->cambiarEstadoSolicitud($id_servicio, $estado, $obsEstado);

header("Location: ../Vista/solicitud_servicios_variables.php");

?>