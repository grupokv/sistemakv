<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/TipoVehiculo.php");

$tipoVehiculo = new TipoVehiculo();
$operativo = new Operativo();

$id_cliente = $_POST['id_cliente'];

$listarClasesMovilPorIdCliente = $operativo->listarClasesMovilPorIdCliente($id_cliente); 
$listarTV = $tipoVehiculo->listar();

$html = '';

if (count($listarClasesMovilPorIdCliente) > 0) {

	$html .= '<option value="">SELECCIONAR</option>';

	foreach ($listarClasesMovilPorIdCliente as $lcmpic) {
		$tipoVehPorId = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']);
/*
		$html .= '<option value="' . $tipoVehPorId[0]['id_tipo_vehiculo'] . "_" . $id_producto . '">' . $tipoVehPorId[0]['nombre_tipo_vehiculo'] .'</option>';*/
		$html .= '<option value="' . $lcmpic['id'] . '">' . strtoupper($lcmpic['clase_movil_producto']) . ' ( ' . $tipoVehPorId[0]['nombre_tipo_vehiculo'] .' ) </option>';
	}
}else{
	$html .= '<option value="">SELECCIONAR</option>';
	foreach($listarTV as $ltv){
		$html .= '<option value="' . $ltv['id_tipo_vehiculo'] . '">' .  $ltv['nombre_tipo_vehiculo'] . '</option>';
	}
}

echo $html;

?>