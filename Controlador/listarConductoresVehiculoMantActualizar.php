<?php 
require_once "../Modelo/Vehiculo.php";
require_once "../Modelo/Conductor.php";
require_once("../Modelo/OrdenServicio.php");

$id_vehiculo = $_POST['id_vehiculo'];
$id_orden_servicio = $_POST['id_orden_servicio'];

$conductor = new Conductor();
$vehiculo = new Vehiculo();
$orden = new OrdenServicio();

$listarOrdenId = $orden->listarPorId($id_orden_servicio);

print_r($listarOrdenId);
$listarConductorPorVehiculo = $vehiculo->listarConductoresPorId($id_vehiculo);


$cant = count($listarConductorPorVehiculo);
//echo $cant;


if ($cant > 0) {
    if (($listarOrdenId[0]['solicitado_por'] == "") || ($listarOrdenId[0]['solicitado_por'] != $listarCId[0]['nombre_conductor'])) {
        $html .= '<option value="" selected="selected">SELECCIONAR</option>';
    }
    foreach ($listarConductorPorVehiculo as $lcpv) {
        $id_conductor1 = $lcpv['id_conductor'];
        $listarCId = $conductor->listarPorId($id_conductor1);
        if ($listarOrdenId[0]['solicitado_por'] == $listarCId[0]['nombre_conductor']) {
        	$html .= '<option value="'.$listarCId[0]['nombre_conductor'].'" selected="selected">'.$listarCId[0]['nombre_conductor'].'</option>';
    	}else{
    		$html .= '<option value="'.$listarCId[0]['nombre_conductor'].'">'.$listarCId[0]['nombre_conductor'].'</option>';
    	}
    }

    if ($listarOrdenId[0]['solicitado_por'] == 'VARADO') {
       	$html .= '<option value="VARADO" selected="selected">VARADO</option>';
	}else{
		$html .= '<option value="VARADO">VARADO</option>';
	}
}
    
echo $html;
 
?>