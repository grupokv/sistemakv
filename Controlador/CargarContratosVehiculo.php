<?php

include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo-Contrato.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Cliente.php");

$id_vehiculo = $_POST['id_vehiculo'];

$vehiculo_contrato = new Vehiculo_Contrato();
$vehiculo = new Vehiculo();
$contrato = new Contrato();
$empresa = new Empresa();
$cliente = new Cliente();

$listarPorVehiculo = $vehiculo_contrato->listarPorVehiculo($id_vehiculo);
    
$html = '';

if(count($listarPorVehiculo) > 0){
    $html .= '<option value="-">SELECCIONAR CONTRATO</option>';
    
    foreach($listarPorVehiculo as $lpv){
        $listarContratoPorID = $contrato->listarId($lpv['id_contrato']);
        
		$tipo_contrato = $contrato->listarTiposContratosId($listarContratoPorID[0]["id_tipo_contrato"]);
        $emp = $empresa->listarPorId($listarContratoPorID[0]['id_empresa']);
        $cli = $cliente->listarClientePorId($listarContratoPorID[0]['id_cliente']);
        
		$html .= '<option value="'. $listarContratoPorID[0]['id_contrato']. '" > No. interno ' . $listarContratoPorID[0]['id_contrato']." - Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'] .' - '. $tipo_contrato[0]["tipo_contrato"].'</option>';
        
    }
    
}else{
    $html .= '<option value="0">EL VEHICULO NO ESTÁ ANCLADO A NINGUN CONTRATO</option>';
}


echo $html;

?>