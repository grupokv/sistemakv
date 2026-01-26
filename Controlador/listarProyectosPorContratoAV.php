<?php 

require_once '../Modelo/Contrato.php';

$id_contrato = $_POST['id_contrato'];

$contrato = new Contrato();

$html = '';
$listarProyectosPorIdContrato = $contrato->listarProyectosContratos($id_contrato);


if (count($listarProyectosPorIdContrato) >= 1) {
	$html .= '<option>SELECCIONAR</option>';
	foreach ($listarProyectosPorIdContrato as $lppic) {
		$html .= '<option value="' . $lppic['id_proyecto'] .'">' . $lppic['nombre_proyecto'] .'</option>';
	}
}else{
	$html .= '<option disabled selected="selected">Este contrato no tiene proyectos anclados</option>';
}


echo $html;
?>
