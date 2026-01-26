<?php 
require_once '../Modelo/Facturacion.php';

$id_facturacion = $_GET['id_facturacion'];

if (!isset($id_facturacion)) {
	
}else{
	$facturacion = new Facturacion();
	$culminar = $facturacion->culminarFacturacion($id_facturacion);
}

header('Location: ../Vista/facturaciones.php');
 ?>
