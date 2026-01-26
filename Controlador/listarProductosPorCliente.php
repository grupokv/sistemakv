<?php  

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$operativo = new Operativo();

$id_cliente = $_POST['id_cliente'];
$listarProductosPorCliente = $operativo->listarProductosPorCliente($id_cliente);

$html = '';

if (count($listarProductosPorCliente) > 0) {

	$html .= '<option value="">SELECCIONAR</option>';

	foreach ($listarProductosPorCliente as $lppc) {
		$html .= '<option value="' . $lppc['id_producto'] .'">' . strtoupper($lppc['detalle_producto']) . ' - ' . $lppc['tipo_producto'] .'</option>';
	}

}

echo $html;

?>