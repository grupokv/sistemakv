<?php 
require_once("../Modelo/DetalleOperacion.php");
require_once("../Modelo/DetalleGastoPersonal.php");

echo $opciones = $_POST['opciones'];

$precio = $_POST['precio'];
$id_vehiculo = $_POST['id_vehiculo'];
$id_operacion = $_POST['id_operacion'];
$fecha = $_POST['fecha'];

$descripcion = $_POST['descripcion'];
$nombre_persona = $_POST['nombre_persona'];
$fecha_detalle = $_POST['fecha_detalle'];
$precio_detalle_costo = $_POST['precio_detalle_costo'];

/* OPERACION VEHICULAR */
if ($opciones == 1) {
	$detalleOperacion = new DetalleOperacion();
	$registrarD = $detalleOperacion->registrarDetalle($precio, $id_vehiculo, $id_operacion, $fecha);

/*OPERACION PERSONAL*/
}elseif ($opciones == 2) {
	$detalleGastoPersonal = new DetalleGastoPersonal();
	$registrarDCP = $detalleGastoPersonal->registrarDG($descripcion, $nombre_persona, $fecha_detalle, $precio_detalle_costo);
}


header('Location: ../Vista/detalles.php');

 ?>