<?php 

require_once '../Modelo/OrdenServicio.php';

$estado  = $_POST['estado'];
$id_orden_servicioA  = $_POST['id_orden_servicioA'];
$id_orden_servicioR  = $_POST['id_orden_servicioR'];
$id_orden_servicioC  = $_POST['id_orden_servicioC'];
$id_orden_servicioE  = $_POST['id_orden_servicioE'];
$id_orden_servicioE2  = $_POST['id_orden_servicioE2'];
$id_orden_servicioP  = $_POST['id_orden_servicioP'];
$motivo  = $_POST['motivo'];

$ordenServicio = new OrdenServicio();

if ($estado == 'A') {	
	$aprobar = $ordenServicio->aprobar($id_orden_servicioA);
	header("Location: ../Vista/ordenes_servicio_pendientes.php");
}else if($estado == 'R'){
	$rechazar = $ordenServicio->rechazar($id_orden_servicioR, $motivo);
	header("Location: ../Vista/ordenes_servicio_pendientes.php");
}else if($estado == 'C'){
	$rechazar = $ordenServicio->cancelar($id_orden_servicioC, $motivo);
	header("Location: ../Vista/ordenes_servicio.php");
}else if($estado == 'E'){
	$eliminar = $ordenServicio->eliminar($id_orden_servicioE);
	header("Location: ../Vista/ordenes_servicio.php");
}else if($estado == 'E1'){
	$eliminar = $ordenServicio->eliminar($id_orden_servicioE2);
	header("Location: ../Vista/ordenes_servicio.php");
}else if($estado == 'P'){
	$eliminar = $ordenServicio->eliminar($id_orden_servicioP);
	header("Location: ../Vista/ordenes_servicio.php");
}



 ?>
