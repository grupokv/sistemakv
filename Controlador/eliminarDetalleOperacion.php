<?php 
require_once "../Modelo/DetalleOperacion.php";

$id_detalle = $_GET['id_detalle'];
$detalleOperacion = new DetalleOperacion();

if (empty($id_detalle)) {

}else{
	$eliminarDetalle = $detalleOperacion->eliminar($id_detalle);    
	header('Location: ../Vista/detalles.php');
}
 ?>