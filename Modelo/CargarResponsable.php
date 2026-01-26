<?php
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Contrato.php");

$id_contrato = $_POST['contrato'];

if($id_contrato == ''){
	$id_contrato = 0;
}

$contrato = new Contrato();
$ListarResponsable = $contrato->listarId($id_contrato);

//print_r($ListarResponsable);

$html = '';
$cantidad = count($ListarResponsable);

if($cantidad > 0){
	$html .= $ListarResponsable[0]["nombre_responsable"].'|'.$ListarResponsable[0]["numero_documento_responsable"].'|'.$ListarResponsable[0]["direccion_responsable"].'|'.$ListarResponsable[0]["telefono_responsable"];
}

echo $html;
?>

