<?php 
	
	require_once("../Modelo/Contrato.php");
	require_once("../Modelo/TipoVehiculo.php");


	$TipoVehiculo = new TipoVehiculo();

	$contrato = new Contrato();
	
	$id_proyecto = $_POST['id_proyecto'];
	$id_contrato = $_POST['id_contrato'];

	$listarTarifas = $contrato->listarTarifasProyectosId($id_proyecto);

	$html = '';

	if (count($listarTarifas) > 0) {


		$html .= '<table class="table" style="border: hidden;">'; 
			$html .= '<tr class="text-center" style="border: hidden;">'; 
				$html .= '<th width="200">DETALLE</th>'; 
				$html .= '<th>TIPO VEHICULO</th>'; 
				$html .= '<th width="50">TIEMPO COBRO</th>'; 
				$html .= '<th>TARIFA DEL SERVICIO</th>'; 
				$html .= '<th> OPCIONES </th>'; 
			$html .= '</tr>'; 

			foreach ($listarTarifas as $lt) {

	            
				$listarPorId = $TipoVehiculo->listarPorId($lt['id_tipo_vehiculo']);

				$html .= '<tr style="border: hidden;">'; 
					$html .= '<td>' . strtr(strtoupper(utf8_decode($lt['detalle'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") . '</td>'; 
					$html .= '<td class="text-center">' . $listarPorId[0]['nombre_tipo_vehiculo'] . '</td>'; 
					$html .= '<td class="text-center">' . $lt['tiempo_cobro'] . '</td>'; 
					$html .= '<td class="text-center"> $ ' . number_format($lt['costo_servicio']) . '</td>'; 
					$html .= '<td>';
						$html .= '<a href="actualizarTarifasProyecto.php?id_tarifa_proyecto=' . $lt['id_tarifa_proyecto'] . '-' . $id_proyecto .'" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-info mr-1"><i class="fa fa-edit" style="color: #fff"></i></a>';

						$html .= '<a href="../Controlador/eliminarTarifaProyecto.php?id_tarifa_proyecto=' . $lt['id_tarifa_proyecto'] .'" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-danger mr-1"><i class="fa fa-trash" style="color: #fff"></i></a>';
					    
					    $listarTarifasTerceros = $contrato->listarTarifasTerceros($lt['id_tarifa_proyecto']);
	                    
	                    if(count($listarTarifasTerceros) != 0){
					        $html .= '<a style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="listarTarifasTerceros(' . $lt['id_tarifa_proyecto'] .')" class="btn btn-warning mr-1" data-toggle="modal" data-target="#ModalTarifasTerceros"><i class="fa fa-usd" style="color: #fff"></i></a>';
	                    }
	            
					$html .= '</td>';
				$html .= '</tr>'; 
			}

		$html .= '</table>';


	$html .= '<div class="d-flex justify-content-center">';	$html .= '<div class="row d-flex justify-content-center">';
	
	    $html .= '<div class="col-6 d-flex justify-content-center">';
			$html .= '<a style="width: 130px;" href="../Vista/registrarTarifasProyecto.php?id_proyecto=' . $id_proyecto . '" class="btn btn-outline-success"> TARIFAS <span class="ml-1 fa 	fa-plus"></span></a>';
		$html .= '</div>';
	
	    $html .= '<div class="col-6 d-flex justify-content-center">';
		    $html .= '<a style="width: 130px;" href="../Vista/registrarTarifasTerceros.php?id_contrato=' . $id_contrato . '" class="btn btn-outline-info">TERCEROS <span class="fa fa-plus"></span></a>';
	    $html .= '</div>';
	    
	$html .= '</div>';


	}else{
		$html .= '<div><p class="text-center"><strong>ESTE PROYECTO NO TIENE TARIFAS REGISTRADAS</strong></p></div>';

		$html .= '<div class="d-flex justify-content-center">';
			$html .= '<a href="../Vista/registrarTarifasProyecto.php?id_proyecto=' . $id_proyecto . '" class="btn btn-outline-success"> REGISTRAR <span class="ml-1 fa fa-plus"></span></a>';
		$html .= '</div>';
	}
		
echo $html;

?>


