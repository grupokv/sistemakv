<?php 
require_once "../Modelo/Vehiculo.php";
require_once "../Modelo/Conductor.php";

$id_vehiculo = $_POST['id_vehiculo'];
$id_conductor = $_POST['id_conductor'];

$conductor = new Conductor();
$vehiculo = new Vehiculo();

$listarConductorPorVehiculo = $vehiculo->listarConductoresPorId($id_vehiculo);


$cant = count($listarConductorPorVehiculo);
//echo $cant;

    $html = '';
    if ($cant > 0) {
        $html = '<option value="">SELECCIONAR CONDUCTOR/(ES)</option>';
        foreach ($listarConductorPorVehiculo as $lcpv) {
            $id_conductor1 = $lcpv['id_conductor'];
            $listarCId = $conductor->listarPorId($id_conductor1);
            $hoy = date('Y-m-d');

                foreach ($listarCId as $lci) {
                    $listarConductoresDocsVencidos = $conductor->listarDocsVencidosPorIdConductor($lci['id_conductor'], $hoy);

                    if (count($listarConductoresDocsVencidos) > 0) {
                        $html .= '<option value=' .$lcpv['id_conductor'].'" disabled style="color:red;font-weight:bolder" >' . $lci['nombre_conductor']. '</option>';   
                    }else{

                        if($id_conductor != ""){
                            if($lcpv['id_conductor'] == $id_conductor){
                                $html .= '<option value=' .$lcpv['id_conductor'].' selected="selected">' . $lci['nombre_conductor']. '</option>';
                            } else {
                                $html .= '<option value=' .$lcpv['id_conductor'].' >' . $lci['nombre_conductor']. '</option>';
                            }
                        } else {
                            $html .= '<option value=' .$lcpv['id_conductor'].' >' . $lci['nombre_conductor']. '</option>';
                        }

                    }
                    
                }
                
        }
    } else {
        $html .= '<option value="">El vehiculo no tiene conductores asignados</option>';
    }


echo $html;
 ?>