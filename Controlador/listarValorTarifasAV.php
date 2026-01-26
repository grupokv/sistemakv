<?php 
require_once("../Modelo/Contrato.php");

$contrato = new Contrato();

$id_tarifa_proyecto = $_POST['id_tarifa_proyecto'];

$listarIdTarifas = $contrato->listarIdTarifas($id_tarifa_proyecto);
$listarTarifasTerceros = $contrato->listarTarifasTerceros($id_tarifa_proyecto);

if($listarIdTarifas[0]['tiempo_cobro'] == "M"){
    $valorTercero = number_format($listarTarifasTerceros[0]['valor'] / 30);
}else{
    $valorTercero =  number_format($listarTarifasTerceros[0]['valor']);
}

echo $valorTercero;


?>