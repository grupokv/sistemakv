<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Contrato.php");

$id_contrato = $_POST["id_contrato"];


$contrato = new Contrato();
$listarProyectos = $contrato->listarProyectosContratos($id_contrato);

$total = count($listarProyectos);

$html = '';

if ($total >= 1){
	$html .= '<div class="d-flex justify-content-center">';
		$html .= '<table class="table" style="border: hidden;">';
			$html .= '<tr class="text-center" style="border: hidden;">';
				$html .= '<th WIDTH="50">ID</th>';
				$html .= '<th>PROYECTO</th>';
				$html .= '<th>OPCIONES</th>';
			$html .= '</tr>';
				foreach ($listarProyectos as $lp) {
		
					$html .= '<tr class="text-center" style="border: hidden;">';
						$html .= '<td>' . $lp['id_proyecto'] .'</td>';
						$html .= '<td>' . $lp['nombre_proyecto'] .'</td>';
						$html .= '<td>';
							$html .= '<a href="../Vista/actualizarProyectos.php?id_proyecto='. $lp['id_proyecto'] .'" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-info mr-1"><i class="fa fa-edit" style="color: #fff"></i></a>';
							
							$html .= '<a style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="idProyectotarifas(' . $lp['id_proyecto'] .'); listarTarifas(' . $lp['id_proyecto'] . ',' . $lp['id_contrato'] . ');" class="btn btn-danger mr-1" data-toggle="modal" data-target="#ModalTarifas"><i class="fa fa-usd" style="color: #fff"></i></a>';
					  
					$html .= '</td>';

					$html .= '</tr>';
				}
		$html .= '</table>';
	$html .= '</div>';	


	$html .= '<hr>';

	$html .= '<div class=" d-flex justify-content-center">';
		    $html .= '<a href="../Vista/registrarProyectoContratos.php?id_contrato=' . $id_contrato . '" class="btn btn-outline-info"> REGISTRAR <span class="ml-1 fa fa-plus"></span></a>';
	$html .= '</div>';

}else{
	$html .= '<p class="text-center"><strong>ESTE CONTRATO NO TIENE PROYECTOS ANCLADOS.</strong></p>';

	$html .= '<div class="d-flex justify-content-center">';
		$html .= '<a href="../Vista/registrarProyectoContratos.php?id_contrato=' . $id_contrato . '" class="btn btn-outline-info"> REGISTRAR <span class="ml-1 fa fa-plus"></span></a>';
	$html .= '</div>';

}

echo $html; 

?>

