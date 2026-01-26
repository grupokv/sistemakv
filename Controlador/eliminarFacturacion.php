<?php 
require_once '../Modelo/Facturacion.php';

$id_facturacion = $_GET['id_facturacion'];

if (!isset($id_facturacion)) {
	
}else{
	$facturacion = new Facturacion();
	$eliminarFacturacion = $facturacion->eliminar($id_facturacion);

}
header('../Vista/facturaciones.php');

?>
