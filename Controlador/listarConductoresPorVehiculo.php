<?php 
require_once "../Modelo/Vehiculo.php";
require_once "../Modelo/Conductor.php";

$id_vehiculo = $_POST['id_vehiculo'];

$vehiculo = new Vehiculo();
$conductor = new Conductor();

$listarConductorPorVehiculo = $vehiculo->listarConductoresPorId($id_vehiculo);


$cant = count($listarConductorPorVehiculo);
//echo $cant;

    $html = '';
    if ($cant > 0) {
        $html = '<option value="">SELECCIONE CONDUCTOR</option>';
        foreach ($listarConductorPorVehiculo as $lcpv) {
            $listarCId = $conductor->listarPorId($lcpv['id_conductor']);
            $html .= '<option value=' .$lcpv['id_conductor'].' >' . $listarCId[0]['nombre_conductor']. '</option>';      
        }
    } else {
        $html .= '<option value="">El vehiculo no tiene conductores asignados</option>';
    }


echo $html;
 ?>