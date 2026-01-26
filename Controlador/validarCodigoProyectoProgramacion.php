<?php  

require_once ("../Modelo/Programacion.php");

$programacion = new Programacion();

$proyecto = $_POST['proyecto'];
$unidad_operativa = $_POST['unidad_operativa'];

$validarCodigo = $programacion->validarCodigoIdentificativoProgramacion($proyecto, $unidad_operativa);
//print_r($validarCodigo);

$cants = array();

foreach ($validarCodigo as $vcip) {
	$codigoMaxProg = explode("-", $vcip['codigo_identificativo']);
	array_push($cants, $codigoMaxProg[2]);
}

if ($proyecto == 'VEJEZ') {
	echo "V-" . $unidad_operativa . '-' . (max($cants) + 1);	
}else if ($proyecto == 'DISCAPACIDAD') {
	echo "D-" . $unidad_operativa . '-' . (max($cants) + 1);
}else if ($proyecto == 'EMPRESARIAL') {
	echo "E-" . $unidad_operativa . '-' . (max($cants) + 1);	
}else if ($proyecto == 'INFANCIA') {
	echo "I-" . $unidad_operativa . '-' . (max($cants) + 1);
}

?>