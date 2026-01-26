<?php 
require_once '../Modelo/Operacion.php';

$operacion = new Operacion();

$id_operacion = $_GET['id_operacion'];

if (empty($id_operacion)) {
	echo "<script type='text/javascript'>alert('Ocurrio un error y no se pudo eliminar el vehiculo');</script>";
}else{
	$eliminarOperacion = $operacion->eliminarOperacion($id_operacion);
	header('Location: ../Vista/operaciones.php');
}

 ?>