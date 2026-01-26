<?php 
require_once "../Modelo/Vehiculo.php";

$vehiculo = new Vehiculo();

$listarTodos = $vehiculo->listarActivos();

$html = "";
if (count($listarTodos) > 0) {
	foreach ($listarTodos as $ltv) {
		$html .= "<option value='" . $ltv['id_vehiculo'] ."'>" . $ltv['placa'] . ' | ' . $ltv['numero_movil'] . "</option>";
	}
}

echo $html;

 ?>