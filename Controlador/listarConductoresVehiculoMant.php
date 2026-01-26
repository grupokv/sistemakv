<?php 
require_once "../Modelo/Vehiculo.php";
require_once "../Modelo/Conductor.php";

$id_vehiculo = $_POST['id_vehiculo'];

$conductor = new Conductor();
$vehiculo = new Vehiculo();

$listarConductorPorVehiculo = $vehiculo->listarConductoresPorId($id_vehiculo);


$cant = count($listarConductorPorVehiculo);
//echo $cant;


	$html = '<option value="" selected="selected">SELECCIONAR</option>';
    if ($cant > 0) {
        foreach ($listarConductorPorVehiculo as $lcpv) {
            $id_conductor1 = $lcpv['id_conductor'];
            $listarCId = $conductor->listarPorId($id_conductor1);

            $html .= '<option value="'.$listarCId[0]['nombre_conductor'].'">'.$listarCId[0]['nombre_conductor'].'</option>';
        }
        $html .= '<option value="VARADO">VARADO</option>';
    }
echo $html;
 ?>