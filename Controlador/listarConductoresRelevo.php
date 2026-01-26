<?php 
require_once "../Modelo/Vehiculo.php";
require_once "../Modelo/Conductor.php";

$id_vehiculo = $_POST['id_vehiculo'];

$conductor = new Conductor();
$vehiculo = new Vehiculo();


$listarConductoresPorId = $vehiculo->listarConductoresPorId($id_vehiculo);

$html = '';

if (count($listarConductoresPorId) > 0) {

	$html .= '<option value="">SELECCIONAR</option>';

	foreach ($listarConductoresPorId as $lcpi) {
		$html .= '<option value="'. $lcpi['id_conductor'] .'">' . $lcpi['nombre_conductor'] . '</option>';
	}
}else{
	$html .= '<option value="" selected="selected">NO TIENE CONDUCTORES</option>';
}

echo $html;

?>
