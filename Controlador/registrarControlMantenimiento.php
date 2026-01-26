<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$operativo = new Operativo();

$id_vehiculo = $_POST['id_vehiculo'];
$tipo_servicio = $_POST['tipo_servicio'];
$enviado_por = $_POST['enviado_por'];
$fecha_mtto = $_POST['fecha_mtto'];
$detalle_mtto = strtoupper($_POST['detalle_mtto']);
$valor_mtto = $_POST['valor_mtto'];
$forma_pago = $_POST['forma_pago'];
$estado = $_POST['estado'];
$observaciones = strtoupper($_POST['observaciones']);
$id_usuario_creador = $_SESSION['id_usuario'];
$fecha_creacion = date('Y-m-d H:i:s');

$registrarControlMantenimiento = $operativo->registrarControlMantenimiento($id_vehiculo, $tipo_servicio, $enviado_por, $fecha_mtto, $detalle_mtto, $valor_mtto, $forma_pago, $estado, $observaciones, $id_usuario_creador, $fecha_creacion); 

echo "<script>alert('Se ha registrado correctamente el registro.'); window.location.href = '../Vista/controlMantenimientos.php';</script>";

?>