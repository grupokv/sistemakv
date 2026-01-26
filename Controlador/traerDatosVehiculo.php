<?php 
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/TipoVehiculo.php");

$id = $_POST['id_vehiculo'];

$vehiculo = new Vehiculo();
$tipovehiculo = new TipoVehiculo();
$datos = $vehiculo->listarPorId($id);

$cant = count($datos);

$html = '';
if ($cant > 0) {
    $tipo = $tipovehiculo->listarPorId($datos[0]['id_tipo_vehiculo']); 
    $html .= $datos[0]['placa'].'|'.$datos[0]['numero_movil'].'|'.$datos[0]['cant_pasajeros'].'|'.$datos[0]['modelo'].'|'.$tipo[0]['nombre_tipo_vehiculo'].'|'.$datos[0]['tipo_combustible'];
}

echo $html;
?>