<?php 
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/TipoVehiculo.php");

$id_vehiculo = $_POST['id_vehiculo'];

$vehiculo = new Vehiculo();
$tipoVehiculo = new TipoVehiculo();

$listarVehiculoID = $vehiculo->listarPorId($id_vehiculo);
$listarTipoVehiculo = $tipoVehiculo->listarPorId($listarVehiculoID[0]['id_tipo_vehiculo']);

$html = "";

if(($listarVehiculoID[0]['id_tipo_vehiculo'] == 3) || ($listarVehiculoID[0]['id_tipo_vehiculo'] == 4)){ // BUS - BUSETA
    $html .= "<div class='text-center'>";
        $html .= "<b class='m-4'>" . $listarTipoVehiculo[0]['nombre_tipo_vehiculo'] . "</b>";
        $html .= "<img src='../Resources/images/buses_inspeccion.PNG' style='border:1px solid #eeeeee; border-radius:5px;'/>";
    $html .= "</div>";
}else if($listarVehiculoID[0]['id_tipo_vehiculo'] == 2){ // MICROBUS
    $html .= "<div class='text-center'>";
        $html .= "<b class='m-4'>" . $listarTipoVehiculo[0]['nombre_tipo_vehiculo'] . "</b>";
        $html .= "<img src='../Resources/images/van_inspeccion.PNG' style='border:1px solid #eeeeee; border-radius:5px;'/>";
    $html .= "</div>";
}else if($listarVehiculoID[0]['id_tipo_vehiculo'] == 6){ // CAMIONETA 4X4
    $html .= "<div class='text-center'>";
        $html .= "<b class='m-4'>" . $listarTipoVehiculo[0]['nombre_tipo_vehiculo'] . "</b>";
        $html .= "<img src='../Resources/images/4x4_inspeccion.PNG' style='border:1px solid #eeeeee; border-radius:5px;'/>";
    $html .= "</div>";
}else if($listarVehiculoID[0]['id_tipo_vehiculo'] == 5){ // CAMPERO DUSTER
    $html .= "<div class='text-center'>";
        $html .= "<b class='m-4'>" . $listarTipoVehiculo[0]['nombre_tipo_vehiculo'] . "</b>";
        $html .= "<img src='../Resources/images/duster_inspeccion.PNG' style='border:1px solid #eeeeee; border-radius:5px;'/>";
    $html .= "</div>";
}else if($listarVehiculoID[0]['id_tipo_vehiculo'] == 1){ // CARRO
    $html .= "<div class='text-center'>";
        $html .= "<b class='m-4'>" . $listarTipoVehiculo[0]['nombre_tipo_vehiculo'] . "</b>";
        $html .= "<img src='../Resources/images/carro_inspeccion.PNG' style='border:1px solid #eeeeee; border-radius:5px;'/>";
    $html .= "</div>";
}

echo $html;

?>