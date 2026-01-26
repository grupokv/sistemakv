<?php 
require_once "../Modelo/Vehiculo.php";
require_once "../Modelo/Programacion.php";
require_once("../Modelo/Vehiculo-Contrato.php");
require_once("../Modelo/Contrato.php");

$id_servicio = $_POST['id_servicio'];

$vehiculo = new Vehiculo();
$contrato = new Contrato();
$programacion = new Programacion();
$vehiculoContrato = new Vehiculo_Contrato();

$detalle_servicio = $programacion->serviciosPorIdDetalle($id_servicio);

$listarContratoPorCliente = $contrato->listarPorCliente($detalle_servicio[0]['id_cliente']);
$contratos = '';
$i = 0;
foreach ($listarContratoPorCliente as $lcpc) {
	if ($i == count($listarContratoPorCliente)) {
		$contratos .= $lcpc['id_contrato'];
	}else{
		$contratos .= $lcpc['id_contrato'].',';
	}
	$i ++;
}
$vehiculosPorContrato = $vehiculoContrato->listarVehiculosPorContratoBaseApoyo($contratos);

$html = '';
$html .= '<option value="0">SELECCIONAR</option>';
if (count($vehiculosPorContrato) > 0) {
	foreach ($vehiculosPorContrato as $vpc) {
		$listarVehiculosPorId = $vehiculo->listarPorId($vpc['id_vehiculo']);
		$html .= '<option value="'. $listarVehiculosPorId[0]['id_vehiculo'] .'">' . $listarVehiculosPorId[0]['placa']. ' | ' . $listarVehiculosPorId[0]['numero_movil'] . ' - ' .  $vpc['tipo_contrato'] . '</option>';

	}
	$html .= '<option value="0">LISTAR TODOS</option>';
}else{
	$html .= '<option value="0">ESTE CLIENTE NO TIENE VEHICULOS ANCLADOS AL CONTRATO</option>';
}

echo $html;
?>