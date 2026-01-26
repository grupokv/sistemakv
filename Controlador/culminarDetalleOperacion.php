<?php 

require_once '../Modelo/DetalleOperacion.php';

	$id_detalle = $_POST['id_detalle'];
 	$novedad = $_POST['novedad'];
 	$detalleOperacion = new DetalleOperacion();
	$novedad = $detalleOperacion->cambiarEstadoDetalle($id_detalle, $novedad);

	header('Location: ../Vista/detalles.php');


 ?>