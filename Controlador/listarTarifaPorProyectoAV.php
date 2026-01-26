<?php 
require_once '../Modelo/Contrato.php';

$contrato = new Contrato();

$id_proyecto = $_POST['id_proyecto'];

$listarTarifas = $contrato->listarTarifasProyectosId($id_proyecto);


$html = '';

if (count($listarTarifas) >= 1) {
	$html .= '<option>SELECCIONAR</option>';
	foreach ($listarTarifas as $lt) {
		if ($lt['tiempo_cobro'] == 'M') {
			$html .= '<option value=" ' . $lt['id_tarifa_proyecto'] .' "> ' . strtr(strtoupper(utf8_decode($lt['detalle'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") . ' - TARIFA MENSUAL $ ' . number_format($lt['costo_servicio']) . '</option>';
		}else if ($lt['tiempo_cobro'] == 'H') {
			$html .= '<option value=" ' . $lt['id_tarifa_proyecto'] .' "> ' . strtr(strtoupper(utf8_decode($lt['detalle'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") . ' - TARIFA POR HORA  $' . number_format($lt['costo_servicio']) . '</option>';
		}else if ($lt['tiempo_cobro'] == 'S') {
			$html .= '<option value=" ' . $lt['id_tarifa_proyecto'] .' "> ' . strtr(strtoupper(utf8_decode($lt['detalle'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") . ' - TARIFA POR SERVICIO  $' . number_format($lt['costo_servicio']) . '</option>';
		}else{
			$html .= '<option value=" ' . $lt['id_tarifa_proyecto'] .' "> ' . strtr(strtoupper(utf8_decode($lt['detalle'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") . ' - TARIFA DIARIA ' . ' -  $' . number_format($lt['costo_servicio']) . ' </option>';
		}
	}
}else{
	$html .= '<option>ESTE PROYECTO NO TIENE TARIFAS REGISTRADAS.</option>';
}

echo $html;

 ?>