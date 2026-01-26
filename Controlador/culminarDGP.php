<?php 

require_once '../Modelo/DetalleGastoPersonal.php';

$id_detalle_gasto = $_POST['id_detalle_gasto'];
$novedad_finalizacion = $_POST['novedad_finalizacion'];


$detalleGastoPersonal = new DetalleGastoPersonal();
$culminarDG = $detalleGastoPersonal->culminarDG($novedad_finalizacion, $id_detalle_gasto);

header('Location: ../Vista/detalles.php');

 ?>