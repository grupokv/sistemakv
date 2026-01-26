<?php  

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/TipoVehiculo.php");

$tipoVehiculo = new TipoVehiculo();
$operativo = new Operativo();

$data = explode("_", $_POST['data']);
$id_tipo_vehiculo = $data[0];
$id_producto = $data[1];


$servicio = $_POST['servicio'];

$listarTarifasProductosPorID = $operativo->listarTarifasProductosPorIdYTipoVehiculo($id_producto, $id_tipo_vehiculo);
print_r($listarTarifasProductosPorID);
/*
$html = '';

if (count($listarTarifasProductosPorID) > 0) {

	$html .= '<option value="">SELECCIONAR</option>';

	foreach ($listarTarifasProductosPorID as $lppi) {
		$tipoVehPorId = $tipoVehiculo->listarPorId($lppi['id_tipo_vehiculo']);

		$html .= '<option value="' . $tipoVehPorId[0]['id_tipo_vehiculo'] . "_" . $id_producto . '">' . $tipoVehPorId[0]['nombre_tipo_vehiculo'] .'</option>';
	}
}

echo $html;*/

?>