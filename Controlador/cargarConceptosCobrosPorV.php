<?php 
require_once("../Modelo/ConceptosCobro.php");

$conceptoCobro = new ConceptoCobro();

$id_vehiculo = $_POST['id_vehiculo'];

$listarCobrosPorVehiculo = $conceptoCobro->listarCobrosPorVehiculo($id_vehiculo);
//echo count($listarCobrosPorVehiculo);

$html = '';
$html .= '<option value=""> SELECCIONAR </option>';

$id_concepto_actual = "";

if(count($listarCobrosPorVehiculo) > 0){
    foreach ($listarCobrosPorVehiculo as $lcpv) {
        $listarConceptoPorId = $conceptoCobro->listarPorId($lcpv['id_concepto']);
        if($lcpv['id_concepto'] != $id_concepto_actual){
    	    $html .= '<option value="'. $lcpv['id_concepto'] .'"> '. $listarConceptoPorId[0]['detalle_concepto'] .'</option>';
        }
    	
    	
    	$id_concepto_actual = $lcpv['id_concepto'];
    	
    }
}

echo $html;


?>