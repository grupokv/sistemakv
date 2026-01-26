<?php 

require_once '../Modelo/DetalleGastoPersonal.php';

$id_detalle_gasto = $_POST['id_detalle_gasto'];
$descripcion = $_POST['descripcion'];
$nombre_persona = $_POST['nombre_persona'];
$fecha_detalle = $_POST['fecha_detalle'];
$precio = $_POST['precio'];
$estado = $_POST['estado'];

$detalleGastoPersonal = new DetalleGastoPersonal();
$actualizarDGP = $detalleGastoPersonal->actualizarDG($id_detalle_gasto, $descripcion, $nombre_persona, $fecha_detalle, $precio, $estado);

header('Location: ../Vista/detalles.php');

 ?>