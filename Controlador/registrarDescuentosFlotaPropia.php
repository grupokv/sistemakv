<?php
include 'Sesion/autenticar.php';
require_once("../Modelo/FlotaPropia.php");

$id_flota_propia = $_POST['id_flota_propia'];
$detalle = mb_strtoupper($_POST['detalle_descuento']);
$valor = $_POST['valor_descuento'];
$fecha = $_POST['fecha'];

for ($i=0; $i < count($detalle); $i++) { 
	$detalle_descuento = $detalle[$i];
	$valor_descuento = $valor[$i];
	$fecha_descuento = $fecha[$i];

	$flotaPropia = new FlotaPropia();
	$registrar = $flotaPropia->registrarDescuentosFlotaPropia($id_flota_propia, $detalle_descuento, $valor_descuento, $fecha_descuento);
}

 ?>