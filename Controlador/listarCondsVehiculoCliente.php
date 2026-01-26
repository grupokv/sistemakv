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
				 	$html .= '<th style="width: 80%; border: 0;" scope="col">CONDUCTOR</th>';
				 	$html .= '<th style="border: 0;" scope="col">N° CEDULA</th>';
				 	$html .= '<th style="border: 0;" scope="col">LICENCIA</th>';
			$html .= '</tr>';
		$html .= '</thead>';
		foreach ($listarConductoresPorId as $lcpi) {
		
		$html .= '<tbody style="border: 0;">';
			$html .= '<tr>';
				$html .= '<td style="border: 0;">' . $lcpi['nombre_conductor'] .'</td>';
				$html .= '<td style="border: 0;"><a target="_blank" href="../Documentos/Conductores/'.$lcpi['numero_documento_conductor'].'/'.$lcpi['fotocopia_documento'].'">' . $lcpi['numero_documento_conductor'] .'</a></td>';
				$html .= '<td style="border: 0;"><a target="_blank" href="../Documentos/Conductores/'.$lcpi['numero_documento_conductor'].'/'.$lcpi['fotocopia_licencia'].'" class="btn btn-outline-info" style="margin: 0px; padding: 0px 4px 0px 4px;" title=""><span class="fa fa-file ml-1"></span></a></td>';
			$html .= '</tr>';
		$html .= '</tbody>';
		}
	$html .= '</table>';
}
	

echo $html;
 ?>