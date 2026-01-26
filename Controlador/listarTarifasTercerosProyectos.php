<?php 
	
	require_once("../Modelo/Contrato.php");

	$contrato = new Contrato();
	
    $id_tarifa_proyecto = $_POST['id_tarifa_proyecto'];

    $listarTarifasTerceros = $contrato->listarTarifasTerceros($id_tarifa_proyecto);
	                    
	$html = '';    
	   
	if (count($listarTarifasTerceros) > 0) {
        
		$html .= '<table class="table" style="border: hidden;">'; 
			$html .= '<tr class="text-center" style="border: hidden;">'; 
				$html .= '<th>ID</th>'; 
				$html .= '<th>VALOR</th>'; 
			$html .= '</tr>'; 

			foreach ($listarTarifasTerceros as $ltt) {
				$html .= '<tr class="text-center" style="border: hidden;">'; 
					$html .= '<td>' . $ltt['id_tarifa_tercero'] . '</td>'; 
					$html .= '<td class="text-center"> $ ' . number_format($ltt['valor']) . '</td>'; 
					
				$html .= '</tr>'; 
			}
		
		$html .= '</table>';	
	}
	
	echo $html;

?>


