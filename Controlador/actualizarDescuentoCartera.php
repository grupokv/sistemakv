<?php 

require_once("../Modelo/Cartera.php");

$cartera = new Cartera();

$id_descuento = $_POST['id_descuento'];
$id_vehiculo = $_POST['id_vehiculo'];
$id_concepto = $_POST['id_concepto'];
$tipo_descuento = $_POST['tipo_descuento'];
$descuento = $_POST['descuento'];
$fecha_inicial_valido = $_POST['fecha_inicial'];
$fecha_final_valido = $_POST['fecha_final'];
$id_usuario_creador = $_POST['id_usuario_creador'];
$fecha_creacion_descuento = $_POST['fecha_creacion_descuento'];
$estado = $_POST['estado'];

$actualizarDescuentos = $cartera->actualizarDescuentos($id_descuento, $id_vehiculo, $id_concepto, $tipo_descuento, $descuento, $fecha_inicial_valido, $fecha_final_valido, $id_usuario_creador, $fecha_creacion_descuento, $estado);

header("Location: ../Vista/descuentosCartera.php");

?>