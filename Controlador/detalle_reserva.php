<?php 
require_once("../Modelo/Viaje.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Conductor.php");

$id = $_POST['id'];

$viaje = new Viaje();
$conductor = new Conductor();
$vehiculo = new Vehiculo();

$listarId = $viaje->listarOpcionPorId($id);
$datos_viaje = $viaje->listarViajePorId($listarId[0]['id_viaje']);
$datos_conductor =  $conductor->listarPorId($datos_viaje[0]['id_conductor']);
$datos_vehiculo = $vehiculo->listarPorId($datos_viaje[0]['id_vehiculo']);

$html = '';

if (count($listarId) > 0) {


$html .= '<div class="row">';
	$html .= '<section class="col-3 text-center">';
				$html .= '<p><b>PLACA</b></p>';
	$html .= '</section>';
	$html .= '<section class="col-9 text-center">';
		$html .= '<p>' . $datos_vehiculo[0]["placa"] . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-3 text-center">';
				$html .= '<p><b>CONDUCTOR</b></p>';
	$html .= '</section>';
	$html .= '<section class="col-9 text-center">';
		$html .= '<p>' . $datos_conductor[0]["nombre_conductor"] . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-3 text-center">';
				$html .= '<p><b>No. SILLA</b></p>';
	$html .= '</section>';
	$html .= '<section class="col-9 text-center">';
		$html .= '<p>' . $listarId[0]["numero_silla"] . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-3 text-center">';
				$html .= '<p><b>FECHA</b></p>';
	$html .= '</section>';
	$html .= '<section class="col-9 text-center">';
		$html .= '<p>' . $datos_viaje[0]["fecha"] . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-3 text-center">';
				$html .= '<p><b>HORA</b></p>';
	$html .= '</section>';
	$html .= '<section class="col-9 text-center">';
		$html .= '<p>' . $datos_viaje[0]["hora"] . '</p>';
	$html .= '</section>';
$html .= '</div>';

}

echo $html;
?>