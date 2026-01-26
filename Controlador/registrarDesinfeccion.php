<?php 

require_once '../Modelo/Pre-operacionales.php';

date_default_timezone_set('America/Bogota');

$preoperacionales = new PreOperacionales();

$id_vehiculo = $_POST['id_vehiculo'];
$id_conductor = $_POST['id_conductor'];
$id_usuario = $_POST['id_usuario'];
$fecha_creacion = date('Y-m-d H:i:s');

$registrar = $preoperacionales->registrarDesinfeccion($id_vehiculo, $id_conductor, $id_usuario, $fecha_creacion);

header('Location: ../Vista/desinfeccion_ind.php?id=' . $registrar);
?>