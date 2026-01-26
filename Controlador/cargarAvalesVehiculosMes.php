<?php 
	
include ("../Controlador/Sesion/autenticar.php");	
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Cartera.php");

$cartera = new Cartera();
$vehiculo = new Vehiculo();

$fecha = explode("/", $_POST['mes']);
$mes = $fecha[0];
$anio = $fecha[1];

$consultarAvalMesAnio = $cartera->consultarAvalMesAnio($mes, $anio);

$html = '';

for ($i=0; $i < count($consultarAvalMesAnio); $i++) { 
 	$listarVehiculosID = $vehiculo->listarPorId($consultarAvalMesAnio[$i]['id_vehiculo']);
 	//print_r($listarVehiculosID);

 	$html .= '<div class="row mt-3 mb-4">';
        $html .= '<div class="label">';
            $html .= '<label>Vehiculo</label>';
        $html .= '</div>';
        $html .= '<div class="input">';
        	$html .= '<select class="form-control selecpicker" data-live-search="true" name="aval[]" id="aval">';
        		$html .= '<option value="">SELECCIONAR</option>';
        		foreach ($listarVehiculosID as $lvi){
        			$html .= '<option value="'. $consultarAvalMesAnio[$i]['id_aval'] . '">'. $lvi['placa'] . ' | ' . $lvi['numero_movil'] .'</option>';
        		}
        	$html .= '</select>';
        $html .= '</div>';
    $html .= '</div>';
}

echo $html;


?>