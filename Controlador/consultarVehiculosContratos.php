<?php 

require_once '../Modelo/Vehiculo-Contrato.php';

$id_contrato = $_POST['id_contrato'];
$tipo_contrato_base = "BASE";
$tipo_contrato_apoyo = "APOYO";

$vehiculoContrato = new Vehiculo_Contrato();
$listarPorTipoContratoBase = $vehiculoContrato->listarPorTipoContrato($id_contrato, $tipo_contrato_base);
$listarPorTipoContratoApoyo = $vehiculoContrato->listarPorTipoContrato($id_contrato, $tipo_contrato_apoyo);

$html = '';

	$html .= '<div class="alert alert-primary text-center" role="alert" style="height: 35px; line-height: 10px;">';
		$html .= '<strong>BASE</strong>';
	$html .= '</div>';

	if (count($listarPorTipoContratoBase) > 0) {	
		

		$html .= '<table class="table text-center" cellspacing="0">';
			$html .= '<thead>';
				$html .= '<tr>';
					$html .= '<td style=" border: inset 0pt;"><strong>PLACA</strong></td>';
					$html .= '<td style=" border: inset 0pt;"><strong>MOVIL</strong></td>';
				$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
				foreach ($listarPorTipoContratoBase as $lptcb) {
					$html .= '<tr>';
						$html .= '<td style=" border: inset 0pt;">' . $lptcb['placa'] .'</th>';
						$html .= '<td style=" border: inset 0pt;">' . $lptcb['numero_movil'] .'</th>';
					$html .= '</tr>';
				}
			$html .= '</tbody>';
		$html .= '</table>';
	}else{
		$html .= '<div class="col-12 text-center">';
			$html .= '<strong>NO TIENE VEHICULOS ANCLADOS</strong>';
		$html .= '</div>';
	}

	$html .= '<div class="alert alert-primary text-center" role="alert" style="height: 35px; line-height: 10px;">';
		$html .= '<strong>APOYO O BACKUP</strong>';
	$html .= '</div>';

	if (count($listarPorTipoContratoApoyo) > 0) {	
		

		$html .= '<table class="table text-center" cellspacing="0">';
			$html .= '<thead>';
				$html .= '<tr>';
					$html .= '<td style=" border: inset 0pt;"><strong>PLACA</strong></td>';
					$html .= '<td style=" border: inset 0pt;"><strong>MOVIL</strong></td>';
				$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
				foreach ($listarPorTipoContratoApoyo as $lptca) {
					$html .= '<tr>';
						$html .= '<td style=" border: inset 0pt;">' . $lptca['placa'] .'</th>';
						$html .= '<td style=" border: inset 0pt;">' . $lptca['numero_movil'] .'</th>';
					$html .= '</tr>';
				}
			$html .= '</tbody>';
		$html .= '</table>';
	}else{
		$html .= '<div class="col-12 text-center">';
			$html .= '<strong>NO TIENE VEHICULOS ANCLADOS</strong>';
		$html .= '</div>';
	}



echo $html;
 ?>