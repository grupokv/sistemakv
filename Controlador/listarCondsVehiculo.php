<?php 
require_once '../Modelo/Vehiculo.php';

$id_vehiculo = $_POST['id_vehiculo'];

$vehiculo = new Vehiculo();
$listarConductoresPorId = $vehiculo->listarConductoresPorId($id_vehiculo);

$html = '';

if (count($listarConductoresPorId) < 1) {
	$html .= '<p>No tiene conductores anclados.<p>';
}else{

	$html .= '<table class="table"';
		$html .= '<thead >';
			$html .= '<tr>';
				 	$html .= '<th style="width: 200px; border: 0;" scope="col">CONDUCTOR</th>';
				 	$html .= '<th style="border: 0;" scope="col">N° CONDUCTOR</th>';
				 	$html .= '<th style="border: 0;" style="width: 40px;" scope="col">OPCIÓN</th>';
			$html .= '</tr>';
		$html .= '</thead>';
		foreach ($listarConductoresPorId as $lcpi) {
		
		$html .= '<tbody style="border: 0;">';
			$html .= '<tr>';
				$html .= '<td style="border: 0;">' . $lcpi['nombre_conductor'] .'</td>';
				$html .= '<td style="border: 0;">' . $lcpi['numero_documento_conductor'] .'</td>';
				$html .= '<td style="border: 0;"><a target="_blank" href="../Vista/actualizarConductores.php?id_conductor=' . $lcpi['id_conductor'] . '" class="btn btn-outline-info" style="margin: 0px; padding: 0px 4px 0px 4px;" title=""><span class="fa fa-edit ml-1"></span></a></td>';
			$html .= '</tr>';
		$html .= '</tbody>';
		}
	$html .= '</table>';
}
	

echo $html;

?>