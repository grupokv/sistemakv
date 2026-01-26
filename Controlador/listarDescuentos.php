<?php 
 require_once('../Modelo/FlotaPropia.php');

 $id_flota_propia = $_POST['id_flota_propia'];

 $flotaPropia = new FlotaPropia();
 $listarDescuentos = $flotaPropia->listarDescuentosPorId($id_flota_propia);

 $cant = count($listarDescuentos);

$html = '';
	$html .= '<table class="table">';
		$html .= '<thead style="border: hidden;" >';
 	        $html .= '<tr>';
 	        	$html .= '<th>Detalle descuento</th>';
 	        	$html .= '<th>Valor del descuento</th>';
 	        	$html .= '<th>Fecha</th>';
 	        $html .= '</tr>';
 	    $html .= '<thead>';
 		if ($cant > 0) {
 			foreach ($listarDescuentos as $ld) {
 	        	$html .= '<tbody style="border: hidden;">';
 	        	 	$html .= '<tr>';
 	        	 		$html .= '<td>'. $ld['detalle'] .'</td>';
 	        			$html .= '<td>'. '$' . number_format($ld['valor_descuento'], 0) .'</td>';
 	        			$html .= '<td>'. $ld['fecha'] .'</td>';
 	        		$html .= '</tr>';
 	        	$html .= '<tbody>';
 			}
 		}
	$html .= '<table>';
echo $html; 
 ?> 