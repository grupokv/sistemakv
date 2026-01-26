<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$operativo = new Operativo();

$id_mantenimiento = $_POST['id_mantenimiento'];
$id_vehiculo = $_POST['id_vehiculo'];
$tipo_servicio = $_POST['tipo_servicio'];
$enviado_por = $_POST['enviado_por'];
$fecha_mtto = $_POST['fecha_mtto'];
$detalle_mtto = $_POST['detalle_mtto'];
$valor_mtto = $_POST['valor_mtto'];
$forma_pago = $_POST['forma_pago'];
$estado = $_POST['estado'];
$observaciones = $_POST['observaciones'];

$actualizarControlMantenimiento = $operativo->actualizarControlMantenimiento($id_mantenimiento, $id_vehiculo, $tipo_servicio, $enviado_por, $fecha_mtto, $detalle_mtto, $valor_mtto, $forma_pago, $estado, $observaciones); 

echo "<script>alert('Se ha actualizado correctamente el registro.'); window.location.href = '../Vista/controlMantenimientos.php';</script>";

?>