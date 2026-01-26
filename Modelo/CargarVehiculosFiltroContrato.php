<?php
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo-Contrato.php");
require_once("../Modelo/Vehiculo.php");

$idcontrato = $_POST['contrato'];

$vehiculo_contrato = new Vehiculo_Contrato();
$vehiculo = new Vehiculo();

if($idcontrato != 0){
	$ListarVehiculos = $vehiculo_contrato->listarPorContrato($idcontrato);
} else {
	$ListarVehiculos = $vehiculo->listarActivos();
}

//print_r($ListarVehiculos);

$html = '<option value="">SELECCIONAR</option>';
$cantidad = count($ListarVehiculos);
if($cantidad < 1){
	$html = 'No hay vehiculos asignados al contrato';
} else {
	foreach($ListarVehiculos as $lv){
		$datosVehiculo = $vehiculo->listarPorId($lv['id_vehiculo']);
		$hoy = date('Y-m-d');
		$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
		$fecha2 = date('Y-m-d',$fecha2);
		$docs_vacios = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'],$hoy,$fecha2);

		if(count($docs_vacios)>0){
			$html .= '<option value="'.$datosVehiculo[0]["id_vehiculo"].'" disabled style="color:red;font-weight:bolder" >'.$datosVehiculo[0]["placa"].'</option>';
		} else {
			$html .= '<option value="'.$datosVehiculo[0]["id_vehiculo"].'" >'.$datosVehiculo[0]["placa"].'</option>';
		}
		
	}
}
echo $html;
?>
