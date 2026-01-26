<?php 

require_once '../Modelo/DetalleGastoPersonal.php';

$id_detalle_gasto = $_GET['id_detalle_gasto'];
$detalleGastoPersonal = new DetalleGastoPersonal();

if (empty($id_detalle_gasto)) {

}else{
	$eliminarDGP = $detalleGastoPersonal->eliminarDG($id_detalle_gasto);    
	header('Location: ../Vista/detalles.php');
}
 ?>