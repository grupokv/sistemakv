<?php 
require_once '../Modelo/Contrato.php';

$contrato = new Contrato();

$id_proyecto = $_POST['id_proyecto'];
$id_tarifa_proyecto = $_POST['id_tarifa_proyecto'];
$detalle = $_POST['detalle'];
$id_tipo_vehiculo = $_POST['id_tipo_vehiculo'];
$tiempo_cobro = $_POST['tiempo_cobro'];
$costo_servicio = $_POST['costo_servicio'];

$actualizarTarifa = $contrato->actualizaTarifas($id_tarifa_proyecto, $id_proyecto, $detalle, $id_tipo_vehiculo, $tiempo_cobro, $costo_servicio);



echo "<script>alert('La tarifa se actualiz¨® correctamente.'); window.location.href='../Vista/contratos.php';</script>";
 ?>