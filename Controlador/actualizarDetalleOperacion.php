<?php 

require_once("../Modelo/DetalleOperacion.php");

$id = $_POST['id_detalle'];
$precio = $_POST['precio'];
$id_vehiculo = $_POST['id_vehiculo'];
$id_operacion = $_POST['id_operacion'];
$fecha = $_POST['fecha'];

$detalleOperacion = new DetalleOperacion();
$actualizarDetalle = $detalleOperacion->actualizarDetalle($id, $id_operacion, $id_vehiculo, $fecha, $precio);

header('Location: ../Vista/detalles.php');

 ?>