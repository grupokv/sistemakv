<?php
require_once "../Modelo/Vehiculo.php";
$id_vehiculo = $_POST['id_vehiculo'];
$vehiculo = new Vehiculo();
$listarTodos = $vehiculo->listarActivos();

$html = "";
if (count($listarTodos) > 0) {
	foreach ($listarTodos as $ltv) {		if($ltv['id_vehiculo'] == $id_vehiculo){		$html .= "<option value='" . $ltv['id_vehiculo'] ."' selected='selected'>" . $ltv['placa'] . ' | ' . $ltv['numero_movil'] . "</option>";		} else {
		$html .= "<option value='" . $ltv['id_vehiculo'] ."'>" . $ltv['placa'] . ' | ' . $ltv['numero_movil'] . "</option>";		}
	}
}

echo $html;

 ?>