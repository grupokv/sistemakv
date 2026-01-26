<?php 
require_once '../Modelo/Cliente.php';

$cliente = new Cliente();
$listarTodos = $cliente->listar();

$html = '';

foreach ($listarTodos as $lic) {
	$html .= "<option value=''>SELECCIONAR</option>";
	$html .= "<option value='".$lic["id_cliente"]."'>".$lic["razon_social"]."</option>";
}
	
	
echo $html;
 ?>