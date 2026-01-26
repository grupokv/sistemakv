<?php 
require_once '../Modelo/Vehiculo-Conductor.php';

$id_conductor = $_POST['id_conductor'];

$veh_cond = new Vehiculo_Conductor();
$listado = $veh_cond->listarPorId($id_conductor);

$html = '';

if (count($listado) < 1) {
	$html .= '<p>No tiene vehiculos anclados.<p>';
}else{

	$html .= '<table class="table"';
		$html .= '<thead >';
			$html .= '<tr>';
				 	$html .= '<th style="width: 200px; border: 0;" scope="col">PLACA</th>';
				 	$html .= '<th style="border: 0;" scope="col">N° MOVIL</th>';
				 	$html .= '<th style="border: 0;" style="width: 40px;" scope="col">OPCIÓN</th>';
			$html .= '</tr>';
		$html .= '</thead>';
		foreach ($listado as $lcpi) {
		
		$html .= '<tbody style="border: 0;">';
			$html .= '<tr>';
				$html .= '<td style="border: 0;">' . $lcpi['placa'] .'</td>';
				$html .= '<td style="border: 0;">' . $lcpi['numero_movil'] .'</td>';

				$html .= '<td style="border: 0;"><a target="_blank" href="../Vista/actualizarVehiculo.php?id_vehiculo=' . $lcpi['id_vehiculo'] . '" class="btn btn-outline-info" style="margin: 0px; padding: 0px 4px 0px 4px;" title=""><span class="fa fa-edit ml-1"></span></a></td>';
		
			$html .= '</tr>';
		$html .= '</tbody>';
		}
	$html .= '</table>';
}
	

echo $html;
 ?>