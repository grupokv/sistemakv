<?php 

require_once("../Modelo/Vehiculo.php");

$id_vehiculo = $_POST['id_vehiculo'];

$vehiculo = new Vehiculo();
$listarConductoresPorVehiculo = $vehiculo->listarConductoresPorVehiculo($id_vehiculo);


$html = '';


$cant = 0;
if(count($listarConductoresPorVehiculo) > 0){

    foreach ($listarConductoresPorVehiculo as $lcpv) {
        
    	if ($lcpv['fecha_vencimiento_licencia'] <= date('Y-m-d')) {
    	   $cant = $cant + 1;
    	}
    	
    }
    
    if($cant > 0){
		$html .= '<div class="col-12 p-2" style="border:1px dashed red;"><p id="1" style="color: red;">Uno o varios de los conductores que están anclados a este vehiculo tienen documentación vencida o no se encontro los documentos correspondientes, no se podrá generar el extracto correctamente hasta verificar y realizar los cambios pertinentes. <span class="fa fa-exclamation-circle" style="font-size: 1.5rem; color: orange;"></span></p><input type="hidden" name="verificarDocsConductor" id="verificarDocsConductor" value="' . $cant  .'"></div>';
	}else{
		$html .= '<input type="hidden" name="verificarDocsConductor" id="verificarDocsConductor" value="0">';
	}
}


echo $html;


?>